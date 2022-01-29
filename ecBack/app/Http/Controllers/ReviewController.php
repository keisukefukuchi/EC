<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($item_id)
    {
        return Review::where('item_id', $item_id)->get();
    }
    public function register(Request $request)
    {
        $item = Review::create([
            'title' => $request->title,
            'star' => $request->star,
            'content' => $request->content,
            'purchaser_id' => $request->purchaser_id,
            'item_id' => $request->item_id,
        ]);
        return new JsonResponse(['content' => $item, 'message' => '作成しました']);
    }

    public function evaluation()
    {
        $items = Review::whereBetween('star', [4, 5])->get();
        return $items->random(4)->all();
    }
}