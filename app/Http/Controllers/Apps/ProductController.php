<?php

namespace App\Http\Controllers\Apps;

use Carbon\Carbon;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorHTML;
use App\Http\Controllers\Controller;
use Faker\Core\Barcode;
use Picqer\Barcode\BarcodeGeneratorSVG;

class ProductController extends Controller
{
    public function index()
    {

        $products = Product::with('category', 'vendor')->latest()->get(['id', 'serial_number', 'title', 'total_stock', 'stock_duz', 'stock_pak', 'stock_pcs', 'category_id', 'vendor_id', 'exp_date', 'created_at', 'withoutPcs', 'dus_pak', 'pak_pcs']);

        $svgBarcodes = [];

        foreach ($products as $product) {
            $serialNumber = $product->serial_number;

            // Create an instance of BarcodeGeneratorSVG
            $generator = new BarcodeGeneratorSVG();

            // Generate SVG barcode for the current product
            $svgBarcode = $generator->getBarcode($serialNumber, $generator::TYPE_CODE_128);

            // Store the SVG barcode in the array along with product information if needed
            $svgBarcodes[] = [
                'serial_number' => $serialNumber,
                'svg_barcode'   => $svgBarcode,
                // Add other product information as needed
            ];
        }

        return view('pages.app.products.index', compact('products', 'svgBarcodes'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get(['id', 'name']);
        $vendors = Vendor::where('status', 1)->get(['id', 'name']);

        return view('pages.app.products._create', compact('categories', 'vendors'));
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $this->validateRequest($request);

        $data = $this->prepareData($request);

        // Assuming $data is the input data from the form
        $withoutPcsChecked = isset($data['without_pcs']) && $data['without_pcs'] == '1';

        if ($withoutPcsChecked) {
            // Checkbox is checked
            $pakPerDus = $data['pak_content'] * $data['pak_pcs'];
            $hasil_perhitungan = countQtyWithoutPcs($data['total_stock'], $pakPerDus);
        } else {
            // Checkbox is not checked
            // Perform the calculation without considering without_pcs
            $pakPerDus = $data['pak_content'] * $data['pak_pcs'];
            $hasil_perhitungan = countQty($data['total_stock'], $pakPerDus, $data['pak_pcs']);
        }

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
            'withoutPcs' => $data['without_pcs'] ?? 0,
            'stock_duz' => $hasil_perhitungan['jumlah_dus'],
            'stock_pak' => $hasil_perhitungan['sisa_pak'],
            'stock_pcs' => $hasil_perhitungan['sisa_biji'] ?? 0,
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
            'without_pcs' => 'boolean'
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
