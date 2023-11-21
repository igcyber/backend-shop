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
        $categories = Category::where('status', 1)->get(['id', 'name']);
        $vendors = Vendor::where('status', 1)->get(['id', 'name']);
        $products = Product::with('category', 'vendor')->latest()->get(['id', 'serial_number', 'title', 'total_stock', 'stock_duz', 'stock_pak', 'stock_pcs', 'category_id', 'vendor_id', 'created_at']);

        return view('pages.app.products.index', compact('categories', 'vendors', 'products'));
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        $data = $this->prepareData($request);

        // total biji perdus
        $bijiPerDus = $data['pak_content'] * $data['pak_pcs'];

        // hitung total dus, sisa pak, dan biji
        $hasil_perhitungan = countQty($data['total_stock'], $bijiPerDus, $data['pak_pcs']);

        // check image request
        $imagePath = $this->uploadImage($request);

        // create product
        $productData = [
            'image' => $imagePath,
            'serial_number' => $data['serial_number'],
            'category_id' => $data['category_id'],
            'vendor_id' => $data['vendor_id'],
            'title' => $data['title'],
            'total_stock' => $data['total_stock'],
            'stock_duz' => $hasil_perhitungan['jumlah_dus'],
            'stock_pak' => $hasil_perhitungan['sisa_pak'],
            'stock_pcs' => $hasil_perhitungan['sisa_biji'],
            'dus_pak' => $data['pak_content'],
            'pak_pcs' => $data['pak_pcs'],
            'exp_date' => $data['exp_date'],
            'short_description' => $data['short_description']
        ];

        $product = Product::create($productData);

        $message = $product ? 'Data Berhasil Disimpan!' : 'Data Gagal Disimpan!';

        // redirect with success or error message
        return redirect()->route('app.products.index')->with(['success' => $message]);
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

    private function validateRequest(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,jpg,png|max:2000',
            'serial_number' => 'required|unique:products',
            'category_id' => 'required',
            'vendor_id' => 'required',
            'title' => 'required',
            'stock' => 'nullable|numeric|max:999|min:0',
            'stock_pack' => 'nullable|numeric|max:999|min:0',
            'stock_pcs' => 'nullable|numeric|max:999|min:0',
        ]);
    }

    private function prepareData(Request $request)
    {
        $data = $request->all();
        $data['total_stock'] = $request->filled('total_stock') ? $data['total_stock'] : 0;
        $data['pak_content'] = $request->filled('pak_content') ? $data['pak_content'] : 0;
        $data['pak_pcs'] = $request->filled('pak_pcs') ? $data['pak_pcs'] : 0;
        $data['exp_date'] = $request->filled('exp_date') ? Carbon::parse($data['exp_date'])->format('Y-m-d') : null;

        return $data;
    }

    private function uploadImage(Request $request)
    {
        if ($request->file('image')) {
            $image = $request->file('image');
            return $image->storeAs('public/products', $image->hashName());
        }

        return null;
    }
}
