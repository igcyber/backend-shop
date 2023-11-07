<?php

namespace App\Http\Controllers\Apps;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckOutController extends Controller
{
    public function index()
    {
        $customer = Customer::where('outlet_id', '=', Auth::user()->id)->first();

        $transaction_id = getInvoiceNumber();
        $sub_total = getCartTotal();
        $cmr_address = $customer->address;
        $seller = $customer->seller->name;
        $outlet = $customer->outlet->name;
        // dd($cart);
        return view('front-end.checkout.checkout', compact('cmr_address', 'sub_total', 'outlet', 'transaction_id', 'seller'));
    }

    public function checkOut(Request $request)
    {
        // dd($request->all());
        //Simpan Data Dari Order Checkout Ke DB
        $order = Order::create([
            'transaction_id' => $request->transaction_id,
            'sales' => $request->seller,
            'outlet' => $request->outlet,
            'sub_total' => $request->sub_total,
            'order_address' => $request->order_address,
            'product_qty' => Cart::content()->count()
        ]);

        //store Order Products
        foreach (Cart::content() as $item) {
            $product = Product::find($item->id);
            $orderProduct = OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->title,
                'unit_price' => $item->price,
                'qty' => $item->qty
            ]);

            //update product qty
            $updateQty = $product->stock - $item->qty;
            $product->stock = $updateQty;
            $product->save();
        }

        $transactions = Transaction::create([
            'order_id' => $order->id,
            'amount' => $order->sub_total
        ]);

        // dd($request->all());

        if ($order && $orderProduct && $transactions) {
            //clear cart
            clearCart();
            //redirect dengan pesan sukses
            return redirect()->route('front.home')->with(['status' => 'success', 'message' => 'Produk Telah Dipesan']);
        } else {
            //redirect dengan pesan error
            return  redirect()->route('front.home')->with(['status' => 'error', 'message' => 'Produk Gagal Dipesan']);
        }
    }
}
