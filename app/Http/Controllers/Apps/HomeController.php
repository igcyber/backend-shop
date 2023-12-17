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
        $maxDiscount = $flashSaleItems->pluck('detailProduct.sell_price_duz')->max();

        // Assuming $flashSaleItems is a collection of FlashSaleItem instances with the 'detailProduct' relationship loaded
        $totalDiscountAmount = $flashSaleItems->map(function ($flashSaleItem) {
            // Assuming 'detailProduct' relationship is loaded and not null
            $detailProduct = $flashSaleItem->detailProduct;

            if ($detailProduct && $detailProduct->sell_price_duz !== null && $detailProduct->discount !== null) {
                // Get the original price before discount
                $originalPrice = $detailProduct->sell_price_duz;

                // Calculate the total discount amount
                return $originalPrice * ($detailProduct->discount / 100);
            } else {
                // Handle the case where detailProduct or its properties are null
                return 0; // or any default value you prefer
            }
        })->max();
        // dd($totalDiscountAmount);
        $categories = Category::where('status', 1)
            ->orderBy('name', 'ASC')
            ->limit(6)
            ->get();

        return view('front-end.index', compact('categories', 'detailProducts', 'flashSaleItems', 'totalDiscountAmount'));
    }
}
