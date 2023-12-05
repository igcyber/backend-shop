<?php

namespace App\Http\Controllers\Apps;

use App\Models\FlashSale;
use Illuminate\Http\Request;
use App\Models\DetailProduct;
use App\Models\FlashSaleItem;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class FlashSaleController extends Controller
{
    //index controller
    public function index()
    {
        $flashSale = FlashSale::first();
        $flashSaleItems = FlashSaleItem::with('detailProduct', 'flashSale')->select('id', 'detail_id', 'flash_id',  'status')->get();
        $detailProducts = DetailProduct::with('product')->select('id', 'product_id')->get();
        $existingDetailIds = FlashSaleItem::pluck('detail_id')->toArray();
        return view('pages.app.flash-sale.index', compact('flashSale', 'detailProducts', 'flashSaleItems', 'existingDetailIds'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'end_date' => 'required'
        ]);

        //convert date from request to database date format
        $data = $request->all();
        $data['end_date'] = $request->filled('end_date') ? Carbon::parse($data['end_date'])->format('Y-m-d') : null;

        $flashSale = FlashSale::updateOrCreate(
            ['id' => 1],
            ['end_date' => $data['end_date']]
        );

        $message = $flashSale ? 'Data Berhasil Disimpan!' : 'Data Gagal Disimpan!';

        // redirect with success or error message
        return redirect()->route('app.flash.sales')->with(['success' => $message]);
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'product_flash' => 'required',
            'status' => 'required'
        ]);

        $flashSale = FlashSale::firstOrFail();
        $flashSaleItem = new FlashSaleItem();
        $flashSaleItem->detail_id = $request->product_flash;
        $flashSaleItem->flash_id = $flashSale->id;
        $flashSaleItem->status = $request->status;

        // Check if discount is 0, and set status accordingly
        $flashSaleItem->status = $request->status;
        if ($flashSaleItem->detailProduct->discount == 0) {
            $flashSaleItem->status = 0;
        }

        $storedData = $flashSaleItem->save();

        $message = $storedData ? 'Data Berhasil Disimpan!' : 'Data Gagal Disimpan!';

        // redirect with success or error message
        return redirect()->route('app.flash.sales')->with(['success' => $message]);
    }

    public function changeStatus(Request $request)
    {
        try {
            $flashSale = FlashSaleItem::findOrFail($request->id);

            // Update status based on request parameter
            $flashSale->status = $request->status == 'true' ? 1 : 0;

            $discount = $flashSale->detailProduct->discount;

            if ($request->status == 'false' && $discount == 0) {
                // If status is 'false' and discount is 0, set status to 0
                $flashSale->status = 0;
            } elseif ($discount == 0) {
                // If discount is 0, set status to 0 and return error
                $flashSale->status = 0;
                return response(['status' => 'error']);
            }

            $flashSale->save();

            // Return success response
            return response(['status' => 'success']);
        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return response(['status' => 'error']);
        }
    }
}
