<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Purchase;
use App\Models\History;
use App\Models\Point;

class PurchaseController extends Controller
{
    public function index($id)
    {
        return Purchase::where('purchaser_id', $id)->orderBy('created_at', 'desc')->get();
    }

    public function show($id)
    {
        return Purchase::find($id);
    }

    public function store(Request $request)
    {
        Purchase::create([
            'id' => $request->order_id,
            'purchaser_id' => $request->purchaser_id,
            'amount' => $request->amount,
            'destination' => $request->destination,
            'total' => $request->total,
            'used_point' => $request->used_point,
            'get_point' => $request->get_point,
        ]);

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $stripe->charges->create([
            'amount' => $request->total,
            'currency' => 'jpy',
            'customer' => $request->purchaser_id,
            'description' => json_encode($request->items)
        ]);

        $point = Point::where('purchaser_id', $request->purchaser_id)->first();
        $form = [
            'point' => $request->point
        ];
        $point->update($form);
    }

    public function destroy(Request $request)
    {
        Purchase::where('id', $request->order_id)->delete();
    }
}