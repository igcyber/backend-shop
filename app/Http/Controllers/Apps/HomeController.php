<?php

namespace App\Http\Controllers\Apps;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\DetailProduct;
use App\Models\FlashSaleItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Query detail_products where total_stock in products is not equal to zero
        $detailProducts = Cache::remember('detailProducts', 1, function () {
            return DetailProduct::with('product')
                ->whereHas('product', function ($query) {
                    $query->where('total_stock', '>', 0);
                })
                ->select('id', 'product_id', 'discount')
                ->limit(8)
                ->get();
        });

        $flashSaleItems = FlashSaleItem::where('status', 1)
            ->with('detailProduct', 'flashSale')
            ->select('id', 'detail_id', 'flash_id', 'status')
            ->get();

        // relationship is 'detailProducts' and 'discount' is the column name
        $maxDiscount = $flashSaleItems->pluck('detailProduct.discount')->max();


        $categories = Category::where('status', 1)
            ->orderBy('name', 'ASC')
            ->limit(6)
            ->get();

        return view('front-end.index', compact('categories', 'detailProducts', 'flashSaleItems', 'maxDiscount'));
    }
}
