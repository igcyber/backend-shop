<?php

namespace App\Http\Controllers\Apps;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function checkout($user)
    {
        $carts = Cart::where('outlet_id', $user)->get();

        // Filter carts with non-zero quantities
        $nonZeroQuantityCarts = $carts->filter(function ($cart) {
            return $cart->qty_duz > 0 || $cart->qty_pak > 0 || $cart->qty_pcs > 0;
        });

        $subtotal = 0;
        foreach ($nonZeroQuantityCarts as $item) {
            $subtotal += $item->qty_duz * $item->productDetail->sell_price_duz;
            $subtotal += $item->qty_pak * $item->productDetail->sell_price_pak;
            $subtotal += $item->qty_pcs * $item->productDetail->sell_price_pcs;
        }

        return view('front-end.order.index', compact('nonZeroQuantityCarts', 'subtotal'));
    }
    public function order(Request $request, $user)
    {
        try {
            // Fetch customers based on the given outlet ID along with related data.
            $customers = Customer::with(['outlet', 'seller'])->where('outlet_id', $user)->get();
            // Use a transaction to ensure data integrity
            DB::transaction(function () use ($customers, $request) {
                foreach ($customers as $customer) {
                    $order = Order::create([
                        'sales_id' => $customer->sales_id,
                        'customer_name' => $customer->outlet->name,
                        'customer_sales' => $customer->seller->name,
                        'customer_address' => $customer->address,
                        'transaction_id' => getInvoiceNumber(),
                        'total' => $request['subtotal'],
                        'payment_status' => 0,
                        'order_status' => 0,
                    ]);

                    // Iterate over the order details and create corresponding order detail records.
                    for ($i = 0; $i < count($request['detail_id']); $i++) {
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'detail_id' => $request['detail_id'][$i],
                            'qty_duz' => $request['qty_duz'][$i],
                            'qty_pak' => $request['qty_pak'][$i],
                            'qty_pcs' => $request['qty_pcs'][$i],
                            'price_duz' => $request['price_duz'][$i],
                            'price_pak' => $request['price_pak'][$i],
                            'price_pcs' => $request['price_pcs'][$i],
                        ]);
                    }

                    // Retrieve the created order with order details and product details
                    $orderList = Order::with('orderDetails.productDetail')->find($order->id);

                    if ($orderList) {
                        // Loop through order details and update product stock
                        foreach ($orderList->orderDetails as $orderDetail) {
                            $productDetail = $orderDetail->productDetail;

                            // Retrieve conversion factors from the product
                            $duzToPakFactor = $productDetail->product->dus_pak;
                            $pakToPcsFactor = $productDetail->product->pak_pcs;

                            // Check if the product is withoutPcs
                            $productWithoutPcs = $productDetail->product->withoutPcs;

                            if ($productWithoutPcs) {
                                // If withoutPcs is true, update stock using decStockPack
                                $duzToPak = $orderDetail->qty_duz * $duzToPakFactor * $pakToPcsFactor;
                                $onlyPak =  $orderDetail->qty_pak;
                                $productDetail->product->decStockPack($duzToPak, $onlyPak);
                            } else {
                                // If withoutPcs is false, convert quantities to pcs and update stock
                                $duzToPcs = $orderDetail->qty_duz * $duzToPakFactor * $pakToPcsFactor; // 480 pcs
                                $pakToPcs = $orderDetail->qty_pak * $pakToPcsFactor; // 4 * 20
                                $pcs = $orderDetail->qty_pcs;

                                // Update stock based on quantities in pcs
                                $productDetail->product->decrementStock($duzToPcs, $pakToPcs, $pcs);
                            }
                        }
                    }
                }
            });

            // Delete items from the cart for the given outlet.
            Cart::where('outlet_id', $user)->delete();

            // Redirect the user to the front home page with a success message.
            return redirect(route('front.home'))->with('success', 'Pesanan Berhasil Dikirim');
        } catch (\Exception $e) {
            // Handle exceptions, you might want to log the error for debugging
            // dd($e->getMessage()); // Debug statement to check the exception message
            return redirect()->back()->with('error', 'Terjadi kesalahan. Mohon coba lagi.');
        }
    }
}
