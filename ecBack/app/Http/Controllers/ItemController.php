<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function index() //一覧全部取得
    {
        return Item::orderBy('created_at', 'desc')->get();
    }
    public function index_public8()
    {
        return Item::where('public', 1)->orderBy('created_at', 'desc')->take(8)->get();
    }
    public function index_public()
    {
        return Item::where('public', 1)->orderBy('created_at', 'desc')->paginate(12);
    }
    public function show($id) //商品詳細用　一つだけ取得
    {
        return Item::with('category:id,name')->find($id);
    }
    public function category($id) //カテゴリー表示
    {
        return Item::where('category_id', $id)->orderBy('created_at', 'desc')->paginate(12);
    }
    public function register(Request $request) //商品新規登録
    {
        $item_data = json_decode($request->item);
        $form = [
            'name' => $item_data->name,
            'explanation' => $item_data->explanation,
            'price' => $item_data->price,
            'stock' => $item_data->stock,
            'public' => $item_data->public,
            'recommendation' => $item_data->recommendation,
            'slogan' => $item_data->slogan,
            'recommendation_image' => '',
            'category_id' => $item_data->category_id
        ];
        if ($request->recommend_image != '') {
            $file_name = Str::random(32);
            $request->recommend_image->storeAs('public/recommendation_image/', $file_name);
            $form['recommendation_image'] = '/storage/recommendation_image/' . $file_name;
        }
        $item = Item::create($form);
        return new JsonResponse(['content' => $item, 'message' => '作成しました']);
    }
    public function update(Request $request) //商品情報更新
    {
        $item_data = json_decode($request->item);
        $form = [
            'name' => $item_data->name,
            'explanation' => $item_data->explanation,
            'price' => $item_data->price,
            'stock' => $item_data->stock,
            'public' => $item_data->public,
            'recommendation' => $item_data->recommendation,
            'slogan' => $item_data->slogan,
            'category_id' => $item_data->category_id
        ];
        if ($request->recommend_image != 'noUpdate') {
            if ($request->recommend_image != '') {
                $file_name = Str::random(32);
                $request->recommend_image->storeAs('public/recommendation_image/', $file_name);
                $form['recommendation_image'] = '/storage/recommendation_image/' . $file_name;
            } else {
                $form['recommendation_image'] = '';
            }
        }
        return Item::where('id', $item_data->id)->update($form);
    }

    public function recommend()
    {
        return Item::where('recommendation', 1)->get();
    }
}