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
        // Query detail_products where total_stock in products is not equal to zero
        $detailProducts = DetailProduct::whereHas('product', function ($query) {
            $query->where('total_stock', '>', 0);
        })->get();

        $categories = Category::where('status', 1)
            ->orderBy('name', 'ASC')
            ->limit(6)
            ->get();

        return view('front-end.index', compact('categories', 'detailProducts'));
    }
}
