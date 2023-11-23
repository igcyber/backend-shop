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
        $products = Product::select('id', 'title')->get();
        $detailProducts = DetailProduct::with('product')->select('id', 'product_id', 'sell_price_duz', 'sell_price_pak', 'sell_price_pcs', 'tax_type', 'periode')->get();
        $existProduct = DetailProduct::pluck('product_id')->toArray();
        $existProducIds = array_unique($existProduct);
        return view('pages.app.p_detail.index', compact('detailProducts', 'products', 'existProducIds'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'sell_price_duz' => 'required',
            'tax_type' => 'required',
            'periode' => 'required',
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

        $detail = DetailProduct::create([
            'product_id' => $request->product_id,
            'sell_price_duz' => $sell_price_duz,
            'sell_price_pak' => $getPricePak,
            'sell_price_pcs' => $getPricePcs ?? 0,
            'tax_type' => $request->tax_type,
            'periode' => $request->periode,
        ]);

        $message = $detail ? 'Data Berhasil Disimpan!' : 'Data Gagal Disimpan!';

        return redirect()->route('app.detail-products.index')->with(['success' => $message]);
    }
}
