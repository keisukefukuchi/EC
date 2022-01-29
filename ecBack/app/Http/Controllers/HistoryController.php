<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\History;

class HistoryController extends Controller
{
    public function store(Request $request)
    {
        History::create([
            'purchase_id' => $request->order_id,
            'item_id' => $request->item_id,
            'quantity' => $request->quantity
        ]);
    }
}