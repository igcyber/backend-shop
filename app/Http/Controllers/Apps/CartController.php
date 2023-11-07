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
        $detail = DetailProduct::findOrFail($request->id);


        if ($detail->product->stock < $request->qty) {
            return response(['status' => 'error', 'message' => 'Jumlah Pesanan Melebihi Stok']);
        }

        $cartData = [];
        $cartData['id'] = $detail->id;
        $cartData['name'] = $detail->product->title;
        $cartData['price'] = $detail->sell_price_duz;
        $cartData['qty'] = $request->qty;
        $cartData['weight'] = 0;
        // $cartData['options']['baal_qty'] = $request->baal_qty;
        $cartData['options']['pack_qty'] = $request->pack_qty;
        // $cartData['options']['pcs_qty'] = $request->pcs_qty;
        // $cartData['options']['price_baal'] = $detail->sell_price_baal;
        $cartData['options']['price_pack'] = $detail->sell_price_pack;
        // $cartData['options']['price_pcs'] = $detail->sell_price_pcs;

        // dd($cartData);
        Cart::add($cartData);
        return response(['status' => 'success', 'message' => 'Disimpan Dalam Keranjang']);
    }

    //show detail cart
    public function cartDetail()
    {
        $cartItems = Cart::content();
        return view('front-end.cart.cart-detail', compact('cartItems'));
    }

    //update cart qty, and total price
    public function updateCart(Request $request)
    {
        // dd($request->all());
        Cart::update($request->rowId, $request->qty);
        // Cart::update($request->rowId, ['options'  => ['baal_qty' => $request->baal_qty]]);
        $productTotal = $this->getProductTotal($request->rowId);
        $rupiahFormat = moneyFormat($productTotal);
        return response(['status' => 'success', 'message' => 'Product Updated Successfully', 'product_total' => $rupiahFormat]);
    }

    //get all product total
    //from single units i.e (duz,baal,pack,pcs)
    public function getProductTotal($rowId)
    {
        $product = Cart::get($rowId);
        // dd($product);
        //hitung banyak unit * harganya persatuan
        $total = $product->price * $product->qty;
        return $total;
    }

    //sum all total price of each product
    public function subTotalCart()
    {
        $total = 0;
        foreach (Cart::content() as $product) {
            $total += $this->getProductTotal($product->rowId);
        }
        return moneyFormat($total);
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
        Cart::remove($rowId);
        return redirect()->back()->with(['status' => 'success', 'message' => 'Product Deleted Successfully']);
    }

    public function countCart()
    {
        return Cart::content()->count();
    }
}
