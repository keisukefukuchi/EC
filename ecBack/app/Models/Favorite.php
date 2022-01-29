<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchaser_id',
        'item_id',
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
}