<?php

namespace App\Http\Controllers\Apps;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\DetailProduct;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    //get all order for spesisific sales
    public function index()
    {
        $userId = auth()->id();
        $orders = Order::with('orderDetails')->where('sales_id', $userId)->get();

        $customers = Customer::where('sales_id', $userId)->get();
        return view('pages.app.sales.index', compact('orders', 'customers'));
    }
    public function takeOrder()
    {
        return view('pages.app.sales.takeOrder');
    }
    public function confirmation($type, Order $order)
    {
        $statusMessage = '';

        if ($type == 'accept') {
            $order->order_status = 1;
            $statusMessage = 'Order Telah Dikonfirmasi';
        } else {
            $order->order_status = 2;
            $statusMessage = 'Order Telah Dibatalkan';
        }

        $order->update();

        return back()->with(['success' => $statusMessage]);
    }
    public function delete(Order $order)
    {
        $order->orderDetails->delete();
        $order->delete();
        return back()->with(['success' => 'Order Berhasil Dihapus']);
    }
}
