<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    public function saveOrDelete(Request $request) //いいねがあったら消す。いいねがなかったら作る
    {
        $favorite =  Favorite::firstOrNew(['purchaser_id' => $request->purchaser_id, 'item_id' => $request->item_id]);
        if (!$favorite->exists) {
            $favorite->save();
        } else {
            $favorite->delete();
        }
    }
    public function show(Request $request) //その商品をいいねしているか
    {
        $favorite =  Favorite::where('purchaser_id', $request->purchaser_id)->where('item_id', $request->item_id)->first();
        if ($favorite == null) return new JsonResponse(['message' => 'お気に入りじゃないよ'], 404);
    }
    public function favoriteItems(Request $request) //お気に入り商品一覧
    {
        $favorites = Favorite::where('purchaser_id', $request->purchaser_id)->with('item')->get();
        $items = [];
        foreach ($favorites as $favorite) {
            $items[] = $favorite->item;
        }
        return $items;
    }
}