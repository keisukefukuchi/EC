<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Purchaser;
use App\Models\Point;
use Illuminate\Support\Str;

class PurchaserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        if (Auth::guard('purchaser')->attempt($credentials)) {
            $request->session()->regenerate();

            return new JsonResponse(['message' => 'ログインしました']);
        }

        return new JsonResponse(['message' => 'ログイン失敗'], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('purchaser')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return new JsonResponse(['message' => 'ログアウトしました']);
    }

    public function register(Request $request)
    {
        $purchaser = Purchaser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET_KEY"));
        $stripe->customers->create([
            'id' => $purchaser->id,
            'email' => $request->email,
            'name' => $request->name,
            // 'payment_method' => 'pm_card_visa',
        ]);
        $stripe->customers->createSource(
            $purchaser->id,
            ['source' => 'tok_visa']
        );
        Point::create([
            'purchaser_id' => $purchaser->id,
            'point' => 0
        ]);
        return new JsonResponse(['message' => '登録しました', 'newUser' => ['email' => $request->email, 'password' => $request->password]]);
    }

    public function update(Request $request)
    {
        Purchaser::find($request->id)->update($request->value);

        if (isset($request->value['name']) || isset($request->value['email'])) {
            $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET_KEY"));
            $stripe->customers->update(
                $request->id,
                $request->value
            );
        }
    }

    public function updateImage(Request $request)
    {
        $file_name = Str::random(32);
        $request->file->storeAs('public/users/', $file_name);
        $form = [
            'image_path' => '/storage/users/' . $file_name
        ];
        Purchaser::where('id', $request->id)->update($form);
    }
}