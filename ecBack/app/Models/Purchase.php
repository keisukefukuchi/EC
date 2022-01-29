<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'purchaser_id',
        'amount',
        'destination',
        'used_point',
        'total',
        'get_point',
    ];
    protected $with = ['histories'];

    public function histories()
    {
        return $this->hasMany('App\Models\History');
    }
    // public function items()
    // {
    //     return $this->hasManyThrough('App\Models\Item', 'App\Models\History', 'purchase_id', 'id', null, 'item_id');
    // }
}