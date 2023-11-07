<?php

namespace App\Http\Controllers\Apps;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Tampilkan Order Berdasrkan Sales yang login
        $orders = Order::where('sales', '=', Auth::user()->name)->get();
        // dd($orders);
        return view('pages.app.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // get orders based on $id
        $order = Order::findOrFail($id);
        return view('pages.app.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changeStatus(Request $request)
    {
        // dd("hello");
        $order = Order::findOrFail($request->id);
        $order->order_status = $request->status;
        $order->save();
        return response(['status' => 'success', 'message' => 'Status Berhasil Diperbarui']);
    }

    public function printInvOrder(string $id)
    {
        // get orders based on $id
        $order = Order::findOrFail($id);
        return view('pages.app.orders.invoice', compact('order'));
    }

    public function printInvoice()
    {
        //Tampilkan Order Berdasrkan Sales yang login
        $orders = Order::where('order_status', '=', 'clear')->get();
        // dd($orders);
        return view('pages.app.orders.index', compact('orders'));
    }
}
