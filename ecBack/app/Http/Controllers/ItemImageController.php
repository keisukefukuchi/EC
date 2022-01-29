<?php

namespace App\Http\Controllers;

use App\Models\ItemImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ItemImageController extends Controller
{
    public function register(Request $request)
    {
        if ($request->delete_id != null) {
            foreach ($request->delete_id as $id) {
                ItemImage::find($id)->delete();
            }
        }
        if ($request->file != null) {
            foreach ($request->file as $file) {
                $file_name = Str::random(32);
                $file->storeAs('public/item-image/', $file_name);
                $form = [
                    'image_path' => '/storage/item-image/' .  $file_name,
                    'item_id' => $request->item_id
                ];
                ItemImage::create($form);
            }
        }
    }
}