<?php

namespace App\Http\Controllers;

use App\Models\ReviewImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReviewImageController extends Controller
{

    public function register(Request $request)
    {

        if ($request->file != null) {
            foreach ($request->file as $file) {
                $file_name = Str::random(32);
                $file->storeAs('public/review-image/', $file_name);
                $form = [
                    'image_path' => '/storage/review-image/' .  $file_name,
                    'review_id' => $request->review_id
                ];
                ReviewImage::create($form);
            }
        }
    }
}