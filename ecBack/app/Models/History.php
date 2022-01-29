<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'item_id',
        'quantity'
    ];

    protected $with = ['item'];

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }
}