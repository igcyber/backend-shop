<?php

namespace App\Http\Controllers\Apps;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\DetailProduct;
use App\Http\Controllers\Controller;

class DetailProductController extends Controller
{
    public function index()
    {

        $detailProducts = DetailProduct::with('product')->select('id', 'product_id', 'sell_price_duz', 'sell_price_pak', 'sell_price_pcs', 'tax_type', 'periode', 'discount')->get();

        return view('pages.app.p_detail.index', compact('detailProducts'));
    }

    public function create()
    {
        $products = Product::select('id', 'title')->get();
        $existProduct = DetailProduct::pluck('product_id')->toArray();
        $existProducIds = array_unique($existProduct);
        return view('pages.app.p_detail._create', compact('products', 'existProducIds'));
    }

    public function edit(Request $request, $id)
    {
        $products = Product::select('id', 'title')->get();
        $detailProduct = DetailProduct::findOrFail($id);
        return view('pages.app.p_detail._edit', compact('products', 'detailProduct'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'sell_price_duz' => 'required',
            'tax_type' => 'required',
            'periode' => 'required',
            'discount' => 'nullable|numeric'
        ]);

        $productContent = Product::findOrFail($request->product_id);

        $sell_price_duz = intval(str_replace(['Rp.', '.', ','], '', $request->sell_price_duz));

        if ($productContent->withoutPcs == 0) {
            // If withoutPcs is equal to 0
            $getPricePak = $sell_price_duz / $productContent->dus_pak;
            $getPricePcs = $getPricePak / $productContent->pak_pcs;
        } elseif ($productContent->withoutPcs == 1) {
            // If withoutPcs is equal to 1
            $getPricePak = $sell_price_duz / $productContent->pak_pcs;
            // Adjust $getPricePcs accordingly if needed
        }

        // Use the 'discount' field from the request
        $discountPercentage = $request->input('discount');

        // Apply the discount if it's provided
        if ($discountPercentage !== null) {
            $discountMultiplier = 1 - ($discountPercentage / 100);
            $sell_price_duz *= $discountMultiplier;
            $getPricePak *= $discountMultiplier;
            $getPricePcs *= $discountMultiplier ?? 0;
        }

        $detail = DetailProduct::create([
            'product_id' => $request->product_id,
            'sell_price_duz' => $sell_price_duz,
            'sell_price_pak' => $getPricePak,
            'sell_price_pcs' => $getPricePcs ?? 0,
            'tax_type' => $request->tax_type,
            'periode' => $request->periode,
            'discount' => $discountPercentage ?? 0,
        ]);

        $message = $detail ? 'Data Berhasil Disimpan!' : 'Data Gagal Disimpan!';

        return redirect()->route('app.detail-products.index')->with(['success' => $message]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'discount' => 'nullable|numeric'
        ]);

        $detailProduct = DetailProduct::findOrFail($id);
        $productContent = Product::findOrFail($request->product_id);

        // Reverse the existing discount to get the original prices
        $originalSellPriceDuz = $detailProduct->sell_price_duz / (1 - ($detailProduct->discount / 100));
        $originalSellPricePak = $detailProduct->sell_price_pak / (1 - ($detailProduct->discount / 100));
        $originalSellPricePcs = $detailProduct->sell_price_pcs / (1 - ($detailProduct->discount / 100));

        // Calculate prices based on withoutPcs
        if ($productContent->withoutPcs == 0) {
            $getPricePak = $originalSellPriceDuz / $productContent->dus_pak;
            $getPricePcs = $getPricePak / $productContent->pak_pcs;
        } elseif ($productContent->withoutPcs == 1) {
            $getPricePak = $originalSellPriceDuz / $productContent->pak_pcs;
            // Adjust $getPricePcs accordingly if needed
        }

        // Use the new 'discount' field from the request
        $newDiscountPercentage = $request->input('discount');

        // Apply the new discount or revert to original prices if discount is 0
        if ($newDiscountPercentage !== null && $newDiscountPercentage != 0) {
            $discountMultiplier = 1 - ($newDiscountPercentage / 100);
            $sell_price_duz = $originalSellPriceDuz * $discountMultiplier;
            $getPricePak *= $discountMultiplier;
            $getPricePcs *= $discountMultiplier ?? 0;
        } else {
            // If new discount is 0, revert to original prices
            $sell_price_duz = $originalSellPriceDuz;
            $getPricePak = $originalSellPricePak;
            $getPricePcs = $originalSellPricePcs;
        }

        // Update the DetailProduct
        $detailProduct->update([
            'product_id' => $request->product_id,
            'sell_price_duz' => $sell_price_duz,
            'sell_price_pak' => $getPricePak,
            'sell_price_pcs' => $getPricePcs ?? 0,
            'tax_type' => $detailProduct->tax_type,
            'periode' => $detailProduct->periode,
            'discount' => $newDiscountPercentage ?? 0,
        ]);

        $message = 'Data Berhasil Diupdate!';
        return redirect()->route('app.detail-products.index')->with(['success' => $message]);
    }
}
