<?php

namespace App\Http\Controllers\Apps;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\DetailProduct;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    //add items to cart
    public function addToCart(Request $request)
    {
        // $product = Product::findOrFail($request->product_id);
        $detail = DetailProduct::findOrFail($request->id);

        $cartData = [];
        $cartData['id'] = $detail->id;
        $cartData['name'] = $detail->product->title;
        // $cartData['qty'] = $request->qty;
        $cartData['price'] = $detail->sell_price_duz;
        $cartData['qty'] = $request->qty;
        $cartData['weight'] = 0;
        $cartData['options']['pack_qty'] = $request->pack_qty;
        $cartData['options']['pcs_qty'] = $request->pcs_qty;
        // $cartData['options']['sell_price_duz'] = $detail->sell_price_duz;

        //totalAmount dihitung berdasarkan harga per-unit * jumlah per-unit yang dipesan
        // $totalAmout = $detail->sell_price_duz * $cartData['qty'] + $detail->sell_price_pack * $cartData['options']['pack_qty'] + $detail->sell_price_pcs * $cartData['qty'];

        // $cartData['price'] = $totalAmout;

        // dd($cartData);
        Cart::add($cartData);
        return response(['status' => 'success', 'message' => 'Added To Cart Successfully']);
    }

    //show detail cart
    public function cartDetail()
    {
        $cartItems = Cart::content();
        // dd($cartItems);
        return view('front-end.cart.cart-detail', compact('cartItems'));
    }

    //update cart qty, and total price
    public function updateCart(Request $request)
    {
        // dd($request->all());
        Cart::update($request->rowId, $request->qty);
        $productTotal = $this->getProductTotal($request->rowId);
        $rupiahFormat = moneyFormat($productTotal);
        return response(['status' => 'success', 'message' => 'Product Updated Successfully', 'product_total' => $rupiahFormat]);
    }

    //get all product total
    public function getProductTotal($rowId)
    {
        $product = Cart::get($rowId);
        return $product->price * $product->qty;
    }

    //delete all item from cart
    public function deleteCart()
    {
        Cart::destroy();
        return response(['status' => 'success', 'message' => 'Cart Cleared Successfully']);
    }

    //delete single item from cart
    public function removeCart($rowId)
    {
        // dd($rowId);
        Cart::remove($rowId);
        return redirect()->back();
    }
}
