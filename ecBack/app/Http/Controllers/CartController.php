<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use App\Models\Item;

class CartController extends Controller
{
    public function show($id)
    {
        $carts = Cart::where('purchaser_id', $id)->with('item')->get();

        return $carts;
    }

    public function add(Request $request)
    {
        Cart::create([
            'purchaser_id' => $request->purchaser_id,
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
        ]);
        return new JsonResponse(['message' => 'カートに追加しました']);
    }

    public function plus(Request $request)
    {
        $cart = Cart::where('item_id', $request->item_id)->where('purchaser_id', $request->purchaser_id)->first();
        $quantity = $cart->quantity;
        $current_quantity = ($quantity + $request->quantity);
        $plus_quantity = [
            'quantity' => $current_quantity
        ];
        $cart->update($plus_quantity);
        return new JsonResponse(['message' => 'カートを更新しました']);
    }

    public function update(Request $request)
    {
        $cart = [
            'quantity' => $request->quantity
        ];

        Cart::where('id', $request->id)->update($cart);
        return new JsonResponse(['message' => 'カートを更新しました']);
    }

    public function destroy(Request $request)
    {
        Cart::where('id', $request->id)->delete();
    }

    public function purchase(Request $request)
    {
        Cart::where('purchaser_id', $request->purchaser_id)->delete();
    }
}