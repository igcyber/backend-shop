<?php

namespace App\Http\Controllers\Apps;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user()->id;
        $orders = Order::with('orderDetails')->where('sales_id', $user)->get();
        return view('pages.app.sales.index', compact('orders'));
    }
}
