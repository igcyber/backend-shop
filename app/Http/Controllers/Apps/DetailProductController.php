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
        $products = Product::all();
        $d_products = DetailProduct::all();
        // dd($d_products);
        return view('pages.app.p_detail.index', compact('d_products', 'products'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'product_id' => 'required',
            'buy_price' => 'required',
            'tax_type' => 'required',
            'periode' => 'required',
        ]);

        // dd($request->all());

        $data = $request->all();
        $data['buy_price'] = intval(str_replace(['Rp.', '.', ','], '',  $data['buy_price']));
        $data['sell_price_duz'] = intval(str_replace(['Rp.', '.', ','], '', $data['sell_price_duz']));
        $data['sell_price_baal'] = intval(str_replace(['Rp.', '.', ','], '', $data['sell_price_baal']));
        $data['sell_price_pack'] = intval(str_replace(['Rp.', '.', ','], '', $data['sell_price_pack']));
        $data['sell_price_pcs'] = intval(str_replace(['Rp.', '.', ','], '', $data['sell_price_pcs']));



        $d_product = DetailProduct::create([
            'product_id' => $request->product_id,
            'buy_price' => $data['buy_price'],
            'sell_price_duz' => $data['sell_price_duz'] ?? 0,
            'sell_price_baal' => $data['sell_price_baal'] ?? 0,
            'sell_price_pack' => $data['sell_price_pack'] ?? 0,
            'sell_price_pcs' => $data['sell_price_pcs'] ?? 0,
            'tax_type' => $request->tax_type,
            'periode' => $request->periode
        ]);

        // dd($d_product);
        if ($d_product) {
            //redirect dengan pesan sukses
            return redirect()->route('app.detail-products.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('app.detail-products.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
}
