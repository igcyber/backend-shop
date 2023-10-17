<?php

namespace App\Http\Controllers\Apps;

use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    //
    public function index(ProductDataTable $dataTable)
    {
        $categories = Category::where('status', 1)->get();
        $vendors = Vendor::where('status', 1)->get();
        return $dataTable->render('pages.app.products.index', compact('categories', 'vendors'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'image' => 'image|mimes:jpeg,jpg,png|max:2000',
            'serial_number' => 'required|unique:products',
            'category_id' => 'required',
            'vendor_id' => 'required',
            'title' => 'required',
            'buy_price' => 'required',
            'sell_price_duz' => 'required',
            'sell_price_pack' => 'required',
            'stock' => 'required',
            'tax_type' => 'required',
            'periode' => 'required',
            'unit' => 'required',
            'is_top' => 'required'
        ]);

        //check image request
        if ($request->file('image')) {
            //upload image
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            //create product
            $product = Product::create([
                'image'  => $image->hashName(),
                'serial_number' => $request->serial_number,
                'category_id' => $request->category_id,
                'vendor_id' => $request->vendor_id,
                'title' => $request->title,
                'buy_price' => $request->buy_price,
                'sell_price_duz' => $request->sell_price_duz,
                'sell_price_pack' => $request->sell_price_pack,
                'stock' => $request->stock,
                'tax_type' => $request->tax_type,
                'periode' => $request->periode,
                'unit' => $request->unit,
                'is_top' => $request->is_top
            ]);
        } else {
            $product = Product::create([
                'serial_number' => $request->serial_number,
                'category_id' => $request->category_id,
                'vendor_id' => $request->vendor_id,
                'title' => $request->title,
                'buy_price' => $request->buy_price,
                'sell_price_duz' => $request->sell_price_duz,
                'sell_price_pack' => $request->sell_price_pack,
                'stock' => $request->stock,
                'tax_type' => $request->tax_type,
                'periode' => $request->periode,
                'unit' => $request->unit,
                'is_top' => $request->is_top
            ]);
        }

        // dd($request->all());

        if ($product) {
            //redirect dengan pesan sukses
            return redirect()->route('app.products.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('app.products.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit(Request $request, $id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
