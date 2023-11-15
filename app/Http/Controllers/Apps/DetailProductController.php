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
        return view('pages.app.p_detail.index', compact('d_products', 'products'));
    }

    public function store(Request $request)
    {
        //validate every request from user's input
        $this->validate($request, [
            'product_id' => 'required',
            'sell_price_duz' => 'required',
            'tax_type' => 'required',
            'periode' => 'required',
        ]);

        //get all the $request
        $data = $request->all();
        //take product_id from $request
        $data['product_id'] = $request->product_id;
        //take sell_price_duz from $request and make in integer value, remove every String
        $data['sell_price_duz'] = intval(str_replace(['Rp.', '.', ','], '',  $data['sell_price_duz']));
        //get data product based one $request->product_id
        $productContent =  Product::where('id', $data['product_id'])->first();
        //get price for pak from sell_price_duz / pak_content
        $getPricePak = $data['sell_price_duz'] / $productContent['pak_content'];
        //get price for pcs from $getPricePak / pak_pcs
        $getPricePcs = $getPricePak / $productContent['pak_pcs'];

        //create data
        $d_product = DetailProduct::create([
            'product_id' => $request->product_id,
            'sell_price_duz' => $data['sell_price_duz'],
            'sell_price_pak' => $getPricePak,
            'sell_price_pcs' =>  $getPricePcs,
            'tax_type' => $request->tax_type,
            'periode' => $request->periode
        ]);

        if ($d_product) {
            //redirect dengan pesan sukses
            return redirect()->route('app.detail-products.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('app.detail-products.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
}
