<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchaser_id',
        'item_id',
        'quantity'
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
}
