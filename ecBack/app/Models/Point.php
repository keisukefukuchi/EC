<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchaser_id',
        'point'
    ];

    public function purchaser()
    {
        return $this->belongsTo('App\Models\Purchaser');
    }
}
