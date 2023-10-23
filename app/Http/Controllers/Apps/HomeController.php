<?php

namespace App\Http\Controllers\Apps;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\DetailProduct;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {

        //tampilkan product dengan stock diatas 0 duz, dan status is_top true
        //urutkan berdasarkan id dari table detail_products dan batasi hanya ambil 8 item
        $detailProducts = DetailProduct::whereHas('product', function ($query) {
            $query->where('stock', '>', 0);
            $query->where('is_top', 1);
        })->orderBy('id', 'ASC')->limit(8)->get();

        // dd($detailProducts);
        // $detailProducts = DetailProduct::where('is_top', 1)
        //     ->orderBy('id', 'ASC')
        //     ->limit(8)
        //     ->get();

        $categories = Category::where('status', 1)
            ->orderBy('name', 'ASC')
            ->limit(6)
            ->get();

        return view('front-end.index', compact('categories', 'detailProducts'));
    }
}
