<?php

namespace App\Http\Controllers\Apps;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
    // public function order(Request $request, $user)
    // {
    //     try {
    //         // Fetch customers based on the given outlet ID along with related data.
    //         $customers = Customer::with(['outlet', 'seller'])->where('outlet_id', $user)->get();
    //         // Use a transaction to ensure data integrity

    //         DB::transaction(function () use ($customers, $request) {
    //             $transactionId = now()->format('Ymd') . Str::random(3);
    //             foreach ($customers as $customer) {
    //                 $order = Order::create([
    //                     'sales_id' => $customer->sales_id,
    //                     'customer_name' => $customer->outlet->name,
    //                     'customer_sales' => $customer->seller->name,
    //                     'customer_address' => $customer->address,
    //                     'transaction_id' => $transactionId,
    //                     'total' => $request['subtotal'],
    //                     'payment_status' => 0,
    //                     'order_status' => 0,
    //                 ]);

    //                 // Iterate over the order details and create corresponding order detail records.
    //                 for ($i = 0; $i < count($request['detail_id']); $i++) {
    //                     OrderDetail::create([
    //                         'order_id' => $order->id,
    //                         'detail_id' => $request['detail_id'][$i],
    //                         'qty_duz' => $request['qty_duz'][$i],
    //                         'qty_pak' => $request['qty_pak'][$i],
    //                         'qty_pcs' => $request['qty_pcs'][$i],
    //                         'price_duz' => $request['price_duz'][$i],
    //                         'price_pak' => $request['price_pak'][$i],
    //                         'price_pcs' => $request['price_pcs'][$i],
    //                     ]);
    //                 }

    //                 // Retrieve the created order with order details and product details
    //                 $orderList = Order::with('orderDetails.productDetail')->find($order->id);

    //                 if ($orderList) {
    //                     // Loop through order details and update product stock
    //                     foreach ($orderList->orderDetails as $orderDetail) {
    //                         $productDetail = $orderDetail->productDetail;

    //                         // Retrieve conversion factors from the product
    //                         $duzToPakFactor = $productDetail->product->dus_pak;
    //                         $pakToPcsFactor = $productDetail->product->pak_pcs;

    //                         // Check if the product is withoutPcs
    //                         $productWithoutPcs = $productDetail->product->withoutPcs;

    //                         if ($productWithoutPcs) {
    //                             // If withoutPcs is true, update stock using decStockPack
    //                             $duzToPak = $orderDetail->qty_duz * $duzToPakFactor * $pakToPcsFactor;
    //                             $onlyPak =  $orderDetail->qty_pak;
    //                             $productDetail->product->decStockPack($duzToPak, $onlyPak);
    //                         } else {
    //                             // If withoutPcs is false, convert quantities to pcs and update stock
    //                             $duzToPcs = $orderDetail->qty_duz * $duzToPakFactor * $pakToPcsFactor; // 480 pcs
    //                             $pakToPcs = $orderDetail->qty_pak * $pakToPcsFactor; // 4 * 20
    //                             $pcs = $orderDetail->qty_pcs;

    //                             // Update stock based on quantities in pcs
    //                             $productDetail->product->decrementStock($duzToPcs, $pakToPcs, $pcs);
    //                         }
    //                     }
    //                 }
    //             }
    //         });

    //         // Delete items from the cart for the given outlet.
    //         Cart::where('outlet_id', $user)->delete();

    //         // Redirect the user to the front home page with a success message.
    //         return redirect(route('front.home'))->with('success', 'Pesanan Berhasil Dikirim');
    //     } catch (\Exception $e) {
    //         // Handle exceptions, you might want to log the error for debugging
    //         // dd($e->getMessage()); // Debug statement to check the exception message
    //         return redirect()->back()->with('error', 'Terjadi kesalahan. Mohon coba lagi.');
    //     }
    // }

    public function order(Request $request, $user)
    {
        try {
            $customers = $this->getCustomers($user);

            DB::transaction(function () use ($customers, $request) {
                foreach ($customers as $customer) {
                    $order = $this->createOrder($customer, $request);

                    $this->createOrderDetails($order, $request);

                    $this->updateProductStock($order);
                }
            });

            $this->clearCart($user);

            return redirect(route('front.home'))->with('success', 'Pesanan Berhasil Dikirim');
        } catch (\Exception $e) {
            // Log::error('Error during order processing: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', $e->getMessage(), ['exception' => $e]);
        }
    }

    private function getCustomers($user)
    {
        return Customer::with(['outlet', 'seller'])->where('outlet_id', $user)->get();
    }

    private function createOrder($customer, $request)
    {
        $transactionId = now()->format('Ymd') . Str::random(3);

        return Order::create([
            'sales_id' => $customer->sales_id,
            'outlet_id' => $customer->outlet_id,
            // 'customer_name' => $customer->outlet->name,
            // 'customer_sales' => $customer->seller->name,
            // 'customer_address' => $customer->address,
            'transaction_id' => $transactionId,
            'total' => $request['subtotal'],
            'payment_status' => 0,
            'order_status' => 0,
        ]);
    }

    private function createOrderDetails($order, $request)
    {
        foreach ($request['detail_id'] as $index => $detailId) {
            OrderDetail::create([
                'order_id' => $order->id,
                'detail_id' => $detailId,
                'qty_duz' => $request['qty_duz'][$index],
                'qty_pak' => $request['qty_pak'][$index],
                'qty_pcs' => $request['qty_pcs'][$index],
                'price_duz' => $request['price_duz'][$index],
                'price_pak' => $request['price_pak'][$index],
                'price_pcs' => $request['price_pcs'][$index],
            ]);
        }
    }

    private function updateProductStock($order)
    {
        $orderList = Order::with('orderDetails.productDetail')->find($order->id);

        if ($orderList) {
            foreach ($orderList->orderDetails as $orderDetail) {
                $this->updateProductStockForOrderDetail($orderDetail);
            }
        }
    }

    private function updateProductStockForOrderDetail($orderDetail)
    {
        $productDetail = $orderDetail->productDetail;
        $duzToPakFactor = $productDetail->product->dus_pak;
        $pakToPcsFactor = $productDetail->product->pak_pcs;

        if ($productDetail->product->withoutPcs) {
            $duzToPak = $orderDetail->qty_duz * $duzToPakFactor * $pakToPcsFactor;
            $onlyPak = $orderDetail->qty_pak;
            $productDetail->product->decStockPack($duzToPak, $onlyPak);
        } else {
            $duzToPcs = $orderDetail->qty_duz * $duzToPakFactor * $pakToPcsFactor;
            $pakToPcs = $orderDetail->qty_pak * $pakToPcsFactor;
            $pcs = $orderDetail->qty_pcs;

            $productDetail->product->decrementStock($duzToPcs, $pakToPcs, $pcs);
        }
    }

    private function clearCart($user)
    {
        Cart::where('outlet_id', $user)->delete();
    }

    public function updateTotalAmount(Order $order)
    {
        // Validate the request data
        request()->validate([
            'total_amount' => 'required|numeric|min:0',
            'disc_bawah' => 'nullable|numeric|min:0|max:100',
        ]);

        // Update the total amount value in the orders table
        $order->update([
            'disc_bawah' => request('disc_bawah'),
            'total' => request('total_amount'),
        ]);

        // Return a response (optional)
        return response()->json(['message' => 'Total amount and Discount updated successfully']);
    }

    public function updateExpDate(Order $order)
    {
        // Validate the request data
        request()->validate([
            'exp_date' => 'nullable|date',
        ]);

        // Update the exp_date value in the orders table
        $order->update([
            'exp_date' => request('exp_date'),
        ]);

        // Return a response (optional)
        return response()->json(['message' => 'Exp_date updated successfully']);
    }
}
