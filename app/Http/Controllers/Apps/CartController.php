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
        $user_id = auth()->user()->id;
        $subtotal = 0;
        foreach ($carts as $item) {
            $subtotal += $item->qty_duz * $item->productDetail->sell_price_duz;
            $subtotal += $item->qty_pak * $item->productDetail->sell_price_pak;
            $subtotal += $item->qty_pcs * $item->productDetail->sell_price_pcs;
        }
        return view('front-end.cart.cart-detail', compact('carts', 'subtotal', 'user_id'));
    }

    public function updateCart(Request $request, $user)
    {
        // dd($request->all());
        // $carts = Cart::where('outlet_id', $user)->pluck('detail_id');
        $request->validate([
            'updates.*.qty_duz' => 'numeric|min:0',
            'updates.*.qty_pak' => 'numeric|min:0',
            'updates.*.qty_pcs' => 'numeric|min:0',
        ]);

        $carts = Cart::where('outlet_id', $user)->get();
        $validationErrors = [];
        foreach ($carts as $cart) {
            $item = $cart->productDetail->product;
            $requestedQtyDuz = $request->input('updates.' . $cart->detail_id . '.qty_duz') ?? 0;
            $requestedQtyPak = $request->input('updates.' . $cart->detail_id . '.qty_pak') ?? 0;
            $requestedQtyPcs = $request->input('updates.' . $cart->detail_id . '.qty_pcs') ?? 0;

            // Fetch the available stock quantity for the current item
            $stockQtyDuz = $item->stock_duz;
            $stockQtyPak = $item->stock_pak;
            $stockQtyPcs = $item->stock_pcs;

            // Validate the requested quantities
            if ($requestedQtyDuz > $stockQtyDuz) {
                // Quantity of qty_duz is invalid
                $validationErrors[] = "Pesanan Barang melebihi Stok Dus Gudang.";
            }

            if ($requestedQtyPak > $stockQtyPak) {
                // Quantity of qty_pak is invalid
                $validationErrors[] = "Pesanan Barang Melebihi Stok Pak Gudang.";
            }

            if ($requestedQtyPcs > $stockQtyPcs) {
                // Quantity of qty_pcs is invalid
                $validationErrors[] = "Pesanan Barang Melebihi Stok Pcs Gudang.";
            }
        }

        // Check if there are validation errors
        if (!empty($validationErrors)) {
            // Convert the validation errors array to a string
            $errorString = implode('<br>', $validationErrors);
            // Redirect back with specific error messages
            return back()->with(['error' => $errorString]);
        } else {
            // Validation is successful, update quantities
            foreach ($carts as $cart) {
                Cart::where('detail_id', $cart->detail_id)->update([
                    'qty_duz' => $request->input('updates.' . $cart->detail_id . '.qty_duz') ?? 0,
                    'qty_pak' => $request->input('updates.' . $cart->detail_id . '.qty_pak') ?? 0,
                    'qty_pcs' => $request->input('updates.' . $cart->detail_id . '.qty_pcs') ?? 0
                ]);
            }

            // Optionally, you can redirect to a success page or show a success message
            return redirect()->route('app.cart.get', $user)->with(['success' => 'Quantities updated successfully']);
        }
    }

    public function deleteCart(Cart $cart, $user)
    {
        $cart->delete();
        return redirect()->route('app.cart.get', $user)->with('success', 'Cart deleted successfully');
    }
}
