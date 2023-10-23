<?php

namespace App\Http\Controllers\Apps;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\DetailProduct;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    //add items to cart
    public function addToCart(Request $request)
    {
        // $product = Product::findOrFail($request->product_id);
        $detail = DetailProduct::findOrFail($request->id);
        $unitTotal = 0;
        // $title = $detail->product->title;

        $cartData = [];
        $cartData['id'] = $detail->id;
        $cartData['name'] = $detail->product->title;
        $cartData['qty'] = $request->qty;
        $cartData['options'][''] = $detail->product->images;
        $cartData['options']['image'] = $detail->product->images;
        $cartData['options']['image'] = $detail->product->images;
        $cartData['weight'] = 0;

        $cartData['price'] = $detail->sell_price_duz * $cartData['qty'];

        // dd($cartData);
    }

    public function cartDetail()
    {
        return view('front-end.cart.cart-detail');
    }
}
