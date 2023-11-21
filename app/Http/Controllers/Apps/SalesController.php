<?php

namespace App\Http\Controllers\Apps;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    //get all order for spesisific sales
    public function index()
    {
        $user = auth()->user()->id;
        $orders = Order::with('orderDetails')->where('sales_id', $user)->get();
        $customers = Customer::where('sales_id', $user)->get();
        return view('pages.app.sales.index', compact('orders', 'customers'));
    }
    public function confirmation($type, Order $order)
    {
        if ($type == 'accept') {
            $order->order_status = 1;
            $order->update();
            return back()->with(['success' => 'Order Telah Dikonfirmasi']);
        }

        $order->order_status = 2;
        $order->update();
        return back()->with(['success' => 'Order Telah Dibatalkan']);
    }
    public function delete(Order $order)
    {
        $order->orderDetails->delete();
        $order->delete();
        return back()->with(['success' => 'Order Berhasil Dihapus']);
    }
}
