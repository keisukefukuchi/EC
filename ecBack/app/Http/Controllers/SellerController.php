<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Seller;

class SellerController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        if (Auth::guard('seller')->attempt($credentials)) {
            $request->session()->regenerate();

            return new JsonResponse(['message' => 'ログインしました']);
        }

        return 'ログインに失敗しました。再度お試しください';
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('seller')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return new JsonResponse(['message' => 'ログアウトしました']);
    }

    public function register(Request $request)
    {
        Seller::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return new JsonResponse(['message' => '登録しました', 'newUser' => ['email' => $request->email, 'password' => $request->password]]);
    }

    public function stripe()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $balance = $stripe->balance->retrieve();
        $paymentsDay = array_filter($stripe->charges->all(['created' => array('gte' => strtotime('-1 day'))])->data, function ($element) {
            return $element['captured'] && !$element['refunded'];
        });
        $paymentsMonth = array_filter($stripe->charges->all(['created' => array('gte' => strtotime('-1 month'))])->data, function ($element) {
            return $element['captured'] && !$element['refunded'];
        });
        $sendData = [
            'balance' => $balance,
            'salesDay' => array_reduce($paymentsDay, function ($carry, $item) {
                return $carry + $item->amount;
            }),
            'salesMonth' => array_reduce($paymentsMonth, function ($carry, $item) {
                return $carry + $item->amount;
            }),
        ];
        return $sendData;
    }
}