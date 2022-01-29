<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'star',
        'content',
        'purchaser_id',
        'item_id',
    ];

    protected $with = ['purchaser', 'reviewImage:review_id,image_path'];
    public function purchaser()
    {
        return $this->belongsTo('App\Models\Purchaser');
    }
    public function reviewImage()
    {
        return $this->hasMany('App\Models\ReviewImage');
    }
}