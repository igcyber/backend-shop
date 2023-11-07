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
        $data['stock'] = $request->filled('stock') ? $data['stock'] : 0;
        $data['stock_baal'] = $request->filled('stock_baal') ? $data['stock_baal'] : 0;
        $data['stock_pack'] = $request->filled('stock_pack') ? $data['stock_pack'] : 0;
        $data['stock_pcs'] = $request->filled('stock_pcs') ? $data['stock_pcs'] : 0;

        // dd($request->all());

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
                'stock' => $data['stock'],
                'stock_baal' => $data['stock_baal'],
                'stock_pack' =>  $data['stock_pack'],
                'stock_pcs' => $data['stock_pcs'],
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
