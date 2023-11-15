<?php

namespace App\Http\Controllers\Apps;

use Carbon\Carbon;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    //
    public function index()
    {
        $categories = Category::where('status', 1)->get();
        $vendors = Vendor::where('status', 1)->get();
        $products = Product::latest()->get();
        return view('pages.app.products.index', compact('categories', 'vendors', 'products'));
    }

    public function store(Request $request)
    {
        // dd($request->all());


        $this->validate($request, [
            'image' => 'image|mimes:jpeg,jpg,png|max:2000',
            'serial_number' => 'required|unique:products',
            'category_id' => 'required',
            'vendor_id' => 'required',
            'title' => 'required',
            'stock' => 'max:999|min:0|nullable|numeric',
            'stock_baal' => 'max:999|min:0|nullable|numeric',
            'stock_pack' => 'max:999|min:0|nullable|numeric',
            'stock_pcs' => 'max:999|min:0|nullable|numeric',
        ]);

        $data = $request->all();
        $data['total_stock'] = $request->filled('total_stock') ? $data['total_stock'] : 0; //total stok dalam satuan biji
        $data['pak_content'] = $request->filled('pak_content') ? $data['pak_content'] : 0; //total pak dalam satu dus
        $data['pak_pcs'] = $request->filled('pak_pcs') ? $data['pak_pcs'] : 0; //total biji dalam satu pak

        //total biji perdus
        $bijiPerDus = $data['pak_content'] * $data['pak_pcs'];

        //hitung total dus, sisa pak, dan biji
        $hasil_perhitungan = countQty($data['total_stock'], $bijiPerDus, $data['pak_pcs']);

        // dd($this->hitungProduk($data['total_stock'], $bijiPerDus, $data['pak_pcs']));

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
                'stock' => $data['stock'],
                'stock_baal' => $data['stock_baal'],
                'stock_pack' =>  $data['stock_pack'],
                'stock_pcs' => $data['stock_pcs'],
                'exp_date' => Carbon::parse($request->exp_date)->format('Y-m-d'),
                'short_description' => $request->short_description
            ]);
        } else {
            $product = Product::create([
                'serial_number' => $request->serial_number,
                'category_id' => $request->category_id,
                'vendor_id' => $request->vendor_id,
                'title' => $request->title,
                'total_stock' => $data['total_stock'],
                'stock_duz' => $hasil_perhitungan['jumlah_dus'],
                'stock_pak' =>  $hasil_perhitungan['sisa_pak'],
                'stock_pcs' => $hasil_perhitungan['sisa_biji'],
                'pak_content' =>  $data['pak_content'],
                'pak_pcs' =>  $data['pak_pcs'],
                'exp_date' => Carbon::parse($request->exp_date)->format('Y-m-d'),
                'short_description' => $request->short_description
            ]);
        }


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
