<?php

namespace App\Http\Controllers\Apps;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function checkout($user)
    {
        $carts = Cart::where('outlet_id', $user)->get();
        $subtotal = 0;
        foreach ($carts as $item) {
            $subtotal += $item->qty_duz * $item->productDetail->sell_price_duz;
            $subtotal += $item->qty_pak * $item->productDetail->sell_price_pak;
            $subtotal += $item->qty_pcs * $item->productDetail->sell_price_pcs;
        }
        return view('front-end.order.index', compact('carts', 'subtotal'));
    }
    public function order(Request $request, $user)
    {
        // Get all requests sent from page
        $req_data = $request->all();
        // Fetch customers based on the given outlet ID.
        $customers = Customer::where('outlet_id', $user)->get();
        // Iterate over the customers and retrieve relevant information.
        foreach ($customers as $customer) {
            //nangkap sales_id dari customer yang pesan
            $sales_id = $customer->sales_id;
            $customer_name = $customer->outlet->name;
            $customer_sales = $customer->seller->name;
            $customer_address = $customer->address;
        }
        // Create a new order using the obtained customer information, along with other details like transaction ID, total, payment status, and order status.
        $order = Order::create([
            'sales_id' => $sales_id,
            'customer_name' => $customer_name,
            'customer_sales' => $customer_sales,
            'customer_address' => $customer_address,
            'transaction_id' => getInvoiceNumber(),
            'total' => $req_data['subtotal'],
            'payment_status' => 0,
            'order_status' => 0,
        ]);
        // Iterate over the order details and create corresponding order detail records.
        for ($i = 0; $i < count($req_data['detail_id']); $i++) {
            OrderDetail::create([
                'order_id' => $order->id,
                'detail_id' => $req_data['detail_id'][$i],
                'qty_duz' => $req_data['qty_duz'][$i],
                'qty_pak' => $req_data['qty_pak'][$i],
                'qty_pcs' => $req_data['qty_pcs'][$i],
                'price_duz' => $req_data['price_duz'][$i],
                'price_pak' => $req_data['price_pak'][$i],
                'price_pcs' => $req_data['price_pcs'][$i]
            ]);
            //Retrieve the order details for the created order
            // $orderDetails = OrderDetail::where('detail_id', $req_data['detail_id'][$i])->get();
            // Decrease the total_stock for each product in the order
            // $this->decreaseProduct($orderDetails);
        }
        // Delete items from the cart for the given outlet.
        Cart::where('outlet_id', $user)->delete();
        // Redirect the user to the front home page with a success message.
        return redirect(route('front.home'))->with('success', 'Pesanan Berhasil Dikirim');
    }

    // public function decreaseProduct($orderDetails)
    // {
    //     foreach ($orderDetails as $orderDetail) {
    //         $product = $orderDetail->productDetail->product;

    //         // Calculate the total quantity ordered
    //         $totalQuantityOrdered = $orderDetail->qty_duz + $orderDetail->qty_pak + $orderDetail->qty_pcs;

    //         // Decrease the total_stock in the products table
    //         $product->decrement('total_stock', $totalQuantityOrdered);
    //     }
    // }
}
