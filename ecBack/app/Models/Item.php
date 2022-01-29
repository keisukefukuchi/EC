<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'explanation',
        'price',
        'stock',
        'public',
        'recommendation',
        'slogan',
        'recommendation_image',
        'category_id'
    ];

    protected $with = ['itemImage:item_id,image_path,id'];
    public function itemImage()
    {
        return $this->hasMany('App\Models\ItemImage');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}