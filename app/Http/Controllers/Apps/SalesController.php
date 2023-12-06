<?php

namespace App\Http\Controllers\Apps;

use Log;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\SalesCart;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\DetailProduct;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    //get all order for spesisific sales
    public function index()
    {
        $userId = auth()->id();
        $orders = Order::with('orderDetails')->where('sales_id', $userId)->get();

        $customers = Customer::where('sales_id', $userId)->get();
        return view('pages.app.sales.index', compact('orders', 'customers'));
    }

    public function editOrderDetail($orderId)
    {
        $detailProducts = DetailProduct::with('product')->select('id', 'product_id', 'sell_price_duz', 'sell_price_pak', 'sell_price_pcs', 'tax_type', 'periode')->get();

        // Find the order by ID
        $order = Order::findOrFail($orderId);

        // Get all order details for the specified order
        $orderDetails = $order->orderDetails;

        // Pass the order and order details to the edit view
        return view('pages.app.sales.edit_order_detail', compact('order', 'orderDetails', 'detailProducts'));
    }

    public function updateOrderDetail($orderId, Request $request)
    {
        $request->validate([
            // 'qty_product' => 'required',
            'qty_product.*' => 'required|numeric', // Ensure each item in the array is present and not empty
            // Add other validation rules as needed
        ]);

        try {
            // Find the order detail by ID
            $orderDetail = OrderDetail::findOrFail($orderId);

            // Update the order detail based on Sales' input
            $orderDetail->update([
                'qty_duz' => $request->input('qty_duz'),
                'qty_pak' => $request->input('qty_pak'),
                'qty_pcs' => $request->input('qty_pcs'),
                'price_duz' => $request->input('price_duz'),
                'price_pak' => $request->input('price_pak'),
                'price_pcs' => $request->input('price_pcs'),
            ]);

            // Optionally, you can return a success response or redirect to a specific page
            return redirect()->route('sales.index')->with('success', 'Order detail updated successfully');
        } catch (\Exception $e) {
            // Handle exceptions, for example, order detail not found
            return back()->with('error', 'Error updating order detail');
        }
    }

    public function order()
    {

        $sales_id = auth()->id();

        $detailProducts = DetailProduct::with('product')->select('id', 'product_id', 'sell_price_duz', 'sell_price_pak', 'sell_price_pcs', 'tax_type', 'periode')->get();

        $salesCart = SalesCart::with('productDetail')->where('sales_id', $sales_id)->get();

        // retrieve the most recent order using orderBy('created_at', 'desc')
        // and get the latest order first.
        $lastOrder = Order::select('transaction_id')
            ->orderBy('created_at', 'desc')
            ->first();

        $customers = Customer::where('sales_id', $sales_id)
            ->with('outlet')
            ->get(['id', 'outlet_id']);

        // If there is a last order, we use its transaction_id as a parameter for getInvoiceNumber
        // and continue from that number.
        if ($lastOrder) {
            $transaction_id = getInvoiceNumber($lastOrder->transaction_id);
        } else {
            // if there is no last order, we call getInvoiceNumber without a parameter,
            // and start from the base value.
            $transaction_id = getInvoiceNumber();
        }

        // return the view
        return view('pages.app.sales.order', compact('transaction_id', 'customers', 'detailProducts', 'salesCart', 'sales_id'));
    }
    public function confirmation($type, Order $order)
    {
        $statusMessage = '';

        if ($type == 'accept') {
            $order->order_status = 1;
            $statusMessage = 'Order Telah Dikonfirmasi';
        } else {
            $order->order_status = 2;
            $statusMessage = 'Order Telah Dibatalkan';
        }

        $order->update();

        return back()->with(['success' => $statusMessage]);
    }
    public function delete(Order $order)
    {
        $order->orderDetails->delete();
        $order->delete();
        return back()->with(['success' => 'Order Berhasil Dihapus']);
    }
    public function addCart($detail, $sales)
    {
        // Check if product is already in the cart
        $existingCart = SalesCart::where('sales_id', $sales)->where('detail_id', $detail)->first();

        // dd($existingCart);

        if ($existingCart) {
            return back()->with('error', 'Barang Sudah Ada Di Keranjang!');
        }

        // Create a new cart entry
        $savedCart = SalesCart::create([
            'sales_id' => $sales,
            'detail_id' => $detail,
            'qty_duz' => 0,
            'qty_pak' => 0,
            'qty_pcs' => 0,
        ]);

        $messageType = $savedCart ? 'success' : 'error';
        $message = $savedCart ? 'Barang Berhasil Ditambahkan Dalam Keranjang' : 'Terjadi Kesalahan Saat Penambahan Barang';

        return back()->with([$messageType => $message]);
    }

    public function createOrder(Request $request, $sales)
    {
        $request->validate([
            // 'qty_product' => 'required',
            'qty_product.*' => 'required|numeric', // Ensure each item in the array is present and not empty
            // Add other validation rules as needed
        ]);
        // Retrieve the updated cart items
        $updatedCart = SalesCart::where('sales_id', $sales)->with('productDetail')->get();
        // Validate and save sales cart data
        $validationErrors = [];
        // dd($request->input('qty_product'));
        // Iterate over the items and save them in sales_carts
        foreach ($request->input('qty_product') as $key => $quantity) {
            // Determine the quantity field based on the selected unit
            $quantityField = 'qty_' . $request->input('satuan')[$key];

            // Retrieve the product detail for the current item
            $productDetail = $updatedCart
                ->where('detail_id', $request->input('detail_id')[$key])
                ->first()
                ->productDetail;

            // Validate the requested quantities against the available stock
            if (!$this->validateRequestedQuantities($quantity, $request->input('satuan')[$key], $productDetail)) {
                $validationErrors[] = "Pesanan Barang Melebihi Stok Gudang untuk produk {$productDetail->product->title}.";
            } else {
                // Save or update the corresponding row in the sales_carts table
                SalesCart::updateOrCreate(
                    [
                        'sales_id' => $sales,
                        'detail_id' => $request->input('detail_id')[$key],
                    ],
                    [
                        $quantityField => $quantity,
                    ]
                );
            }
        }

        // Check if there are validation errors
        if (!empty($validationErrors)) {
            // Handle validation errors here (e.g., redirect back with errors)
            return redirect()->back()->with('error', implode(' ', $validationErrors));
        }

        // Retrieve the updated cart items
        $updatedSalesCart = SalesCart::where('sales_id', $sales)->with('productDetail')->get();

        // Calculate the total
        $total = $updatedSalesCart->sum(function ($item) {
            return $item->qty_duz * $item->productDetail->sell_price_duz +
                $item->qty_pak * $item->productDetail->sell_price_pak +
                $item->qty_pcs * $item->productDetail->sell_price_pcs;
        });

        $customer = Customer::where('sales_id', $sales)
            ->with('outlet', 'seller')
            ->first(['id', 'outlet_id', 'sales_id', 'address']);

        if (!$customer) {
            // Handle the case where no customer is found
            return redirect()->route('app.sales')->with('error', 'Customer not found');
        }

        // Create the order
        $order = Order::create([
            'sales_id' => $sales,
            'transaction_id' => getUniqueTransactionId(),
            'total' => $total,
            'customer_name' => optional($customer->outlet)->name,
            'customer_sales' => optional($customer->seller)->name,
            'customer_address' => $customer->address,
            'order_status' => 1
        ]);

        // Create order details
        $orderDetails = [];
        foreach ($request->input('detail_id') as $key => $detailId) {
            $orderDetails[] = [
                'order_id' => $order->id,
                'detail_id' => $detailId,
                'qty_duz' => $updatedSalesCart[$key]->qty_duz,
                'qty_pak' => $updatedSalesCart[$key]->qty_pak,
                'qty_pcs' => $updatedSalesCart[$key]->qty_pcs,
                'price_duz' => $updatedSalesCart[$key]->productDetail->sell_price_duz,
                'price_pak' => $updatedSalesCart[$key]->productDetail->sell_price_pak,
                'price_pcs' => $updatedSalesCart[$key]->productDetail->sell_price_pcs,
            ];
        }

        // Insert order details in bulk
        OrderDetail::insert($orderDetails);

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

        // Delete items from the cart for the given sales.
        SalesCart::where('sales_id', $sales)->delete();

        // Optionally, you might want to redirect the user after successfully storing the order
        return redirect()->route('app.sales')->with('success', 'Order created successfully');
    }

    public function deleteCart($id)
    {
        $sales_cart = SalesCart::find($id);
        if ($sales_cart) {
            $sales_cart->delete();
            return back()->with('success', 'Produk Berhasil Dihapus');
        }
    }

    // Function to validate requested quantities against available stock
    private function validateRequestedQuantities($requestedQuantity, $unit, $productDetail)
    {
        $isValid = false;

        switch ($unit) {
            case 'duz':
                $isValid = $requestedQuantity <= $productDetail->product->stock_duz;
                break;
            case 'pak':
                $isValid = $requestedQuantity <= $productDetail->product->stock_pak;
                break;
            case 'pcs':
                $isValid = $requestedQuantity <= $productDetail->product->stock_pcs;
                break;
            default:
                $isValid;
        }

        return $isValid;
    }
}
