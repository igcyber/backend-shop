<?php

namespace App\Http\Controllers\Apps;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //add cart function with two product and user parameters
    public function addCart($detail, $user)
    {
        //get data berdasarkan logged in outlet
        $carts = Cart::where('outlet_id', $user)->where('detail_id', $detail)->first();

        //check if product is already exists in cart
        if ($carts) {
            return back()->with(['warning' => 'Barang Sudah Ada Di Keranjang!']);
        } else {
            //else create cart and add it to cart table
            $saved_cart = Cart::create([
                'outlet_id' => $user,
                'detail_id' => $detail,
                'qty_duz' => 0,
                'qty_pak' => 0,
                'qty_pcs' => 0
            ]);
        }

        if ($saved_cart) {
            //redirect back to page with success message
            return back()->with(['success' => 'Barang Berhasil Ditambahkan Dalam Keranjang']);
        } else {
            //redirect back to page with error message
            return back()->with(['error' => 'Terjadi Kesalahan Saat Penambahan Barang']);
        }
    }

    public function getCart($user)
    {
        /** Memuat seluruh data dari tabel cart, berdasarkan outlet_id dengan parameter user */
        $carts = Cart::where('outlet_id', $user)->get();
        // dd($carts);
        // foreach ($carts as $cart) {
        //     dd($cart->id);
        // }
        // $subtotal = 0;
        // foreach ($carts as $item) {
        //     $subtotal += $item->qty_duz * $item->productDetail->sell_price_duz;
        //     $subtotal += $item->qty_pak * $item->productDetail->sell_price_pak;
        //     $subtotal += $item->qty_pcs * $item->productDetail->sell_price_pcs;
        // }
        return view('front-end.cart.cart-detail', compact('carts'));
    }

    public function updateCart(Request $request, $user)
    {
        $carts = Cart::where('outlet_id', $user)->pluck('detail_id');
        foreach ($carts as $detail_id) {
            $updateCart = Cart::where('detail_id', $detail_id)->update([
                'qty_duz' => $request->input('updates.' . $detail_id . '.qty_duz'),
                'qty_pak' => $request->input('updates.' . $detail_id . '.qty_pak'),
                'qty_pcs' => $request->input('updates.' . $detail_id . '.qty_pcs')
            ]);
        }
        if ($updateCart) {
            return redirect(route('app.cart.get', $user));
        }
    }

    public function deleteCart($id)
    {
        // dd($id);
        $cart = Cart::findOrFail($id);
        // Pastikan hanya pemilik item yang dapat menghapusnya
        if (Auth::id() == $cart->outlet_id) {
            $cart->delete();
            return redirect()->back()->with('success', 'Item berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus item ini');
        }
    }
}
