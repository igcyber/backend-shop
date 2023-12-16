<?php

namespace App\Http\Controllers\Apps;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSalesController extends Controller
{
    //
    public function index()
    {
        // Retrieve orders with outlet and customer address
        $orders = Order::join('customers', 'orders.outlet_id', '=', 'customers.outlet_id')
            ->select('orders.*', 'customers.address as customer_address')
            ->with(['orderDetails', 'outlet'])
            ->where('orders.order_status', 1)
            ->get();
        // dd($orders);
        return view('pages.app.admin_sales.index', compact('orders'));
    }
}
