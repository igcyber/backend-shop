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
        // Check if product is already in the cart
        $existingCart = Cart::where('outlet_id', $user)->where('detail_id', $detail)->first();

        if ($existingCart) {
            return back()->with(['warning' => 'Barang Sudah Ada Di Keranjang!']);
        }

        // Create a new cart entry
        $savedCart = Cart::create([
            'outlet_id' => $user,
            'detail_id' => $detail,
            'qty_duz' => 0,
            'qty_pak' => 0,
            'qty_pcs' => 0,
        ]);

        $messageType = $savedCart ? 'success' : 'error';
        $message = $savedCart ? 'Barang Berhasil Ditambahkan Dalam Keranjang' : 'Terjadi Kesalahan Saat Penambahan Barang';

        return back()->with([$messageType => $message]);
    }

    public function getCart($user)
    {
        $carts = Cart::with('productDetail')->where('outlet_id', $user)->get();
        $subtotal = $carts->sum(function ($item) {
            return $item->qty_duz * $item->productDetail->sell_price_duz +
                $item->qty_pak * $item->productDetail->sell_price_pak +
                $item->qty_pcs * $item->productDetail->sell_price_pcs;
        });
        $user_id = auth()->id();
        return view('front-end.cart.cart-detail', compact('carts', 'subtotal', 'user_id'));
    }

    public function updateCart(Request $request, $user)
    {
        $request->validate([
            'updates.*.qty_duz' => 'numeric|min:0',
            'updates.*.qty_pak' => 'numeric|min:0',
            'updates.*.qty_pcs' => 'numeric|min:0',
        ]);

        $validationErrors = [];
        $carts = Cart::with(['productDetail.product'])->where('outlet_id', $user)->get();

        foreach ($carts as $cart) {
            $item = $cart->productDetail->product;

            $requestedQtyDuz = $request->input('updates.' . $cart->detail_id . '.qty_duz') ?? 0;
            $requestedQtyPak = $request->input('updates.' . $cart->detail_id . '.qty_pak') ?? 0;
            $requestedQtyPcs = $request->input('updates.' . $cart->detail_id . '.qty_pcs') ?? 0;

            // Validate the requested quantities
            if ($requestedQtyDuz > $item->stock_duz) {
                $validationErrors[] = "Pesanan Barang melebihi Stok Dus Gudang.";
            }

            if ($requestedQtyPak > $item->stock_pak) {
                $validationErrors[] = "Pesanan Barang Melebihi Stok Pak Gudang.";
            }

            if ($requestedQtyPcs > $item->stock_pcs) {
                $validationErrors[] = "Pesanan Barang Melebihi Stok Pcs Gudang.";
            }
        }

        // Check if there are validation errors
        if (!empty($validationErrors)) {
            $errorString = implode('<br>', $validationErrors);
            return back()->with(['error' => $errorString]);
        }

        // Validation is successful, update quantities
        foreach ($carts as $cart) {
            $detailId = $cart->detail_id;
            $updates = $request->input("updates.$detailId");

            Cart::where('detail_id', $detailId)->update([
                'qty_duz' => $updates['qty_duz'] ?? 0,
                'qty_pak' => $updates['qty_pak'] ?? 0,
                'qty_pcs' => $updates['qty_pcs'] ?? 0,
            ]);
        }

        return redirect()->route('app.cart.get', $user)->with(['success' => 'Quantities updated successfully']);
    }

    public function deleteCart(Cart $cart, $user)
    {
        $cart->delete();
        return redirect()->route('app.cart.get', $user)->with('success', 'Cart deleted successfully');
    }
}
