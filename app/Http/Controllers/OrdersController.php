<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Orders;
use Carbon\Carbon; 

class OrdersController extends Controller
{
    public function get() 
    {
        $orders = Orders::all();
        return response()->json($orders);
    }

    public function store(Request $request) {

        $validated = $request->validate([
            'product_id' => 'required|numeric',
            'product' => 'required|string',
            'price' => 'required|numeric',
        ]);

        Orders::create([
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id,
            'product' => $request->product,
            'customer' => Auth::user()->email,
            'purchase_date' => Carbon::now(),
            'price' => $request->price
        ]);

       return response()->json(['success' => 'Ordered Created']);
    }
}
