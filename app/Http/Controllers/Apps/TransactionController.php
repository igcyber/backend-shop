<?php

namespace App\Http\Controllers\Apps;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index()
    {
        //get cart
        $carts = Cart::with('product')->where('cashier_id', auth()->user()->id)->latest()->get();

        //get all customers
        $customers = Customer::latest()->get();

        //calculate total price
        $carts_total = $carts->sum('price');

        return view('app.transactions.index', compact('carts', 'carts_total', 'customers'));
    }

    public function searchProduct(Request $request)
    {
        //find product by serial_number
        $product = Product::where('serial_number', $request->serial_number)->first();

        if ($product) {
            return response()->json([
                'success' => true,
                'data'    => $product
            ]);
        }

        return response()->json([
            'success' => false,
            'data'    => null
        ]);
    }

    public function addToCart(Request $request)
    {
        //check stock product
        if (Product::whereId($request->product_id)->first()->stock < $request->qty) {

            //redirect
            return redirect()->back()->with('error', 'Out of Stock Product!.');
        }
    }
}
