<?php

namespace App\Http\Controllers\Apps;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function showInvoice($order_id)
    {
        $order = Order::join('customers', 'orders.outlet_id', '=', 'customers.outlet_id')
            ->select('orders.*', 'customers.address as customer_address', 'customers.nomor as customer_id', 'customers.no_telp as customer_phone')
            ->with(['orderDetails' => function ($query) {
                // Eager load the tax_type from order_details
                $query->select('order_details.*', 'tax_type');
            }, 'outlet', 'sales'])
            ->where('orders.id', $order_id)
            ->first();

        if (!$order) {
            // Handle case where the order is not found
            abort(404);
        }

        // Extract tax_type values from orderDetails and concatenate into a string
        $taxTypesString = implode(', ', $order->orderDetails->pluck('tax_type')->unique()->toArray());
        // dd($taxTypesString);

        // Format date when invoice printed
        $order->formatted_printed_at = now()->format('d/m/Y');

        // Calculate the total quantity
        $totalItem = $order->totalItem();

        //Nilai PPN
        $total = $order->total;
        $total = $total / 1.11;
        $total = $total * 0.11;

        return view('pages.app.admin_sales.invoice-show', compact('order', 'taxTypesString', 'total', 'totalItem'));
    }


    public function printInvoice($order_id)
    {
        $order = Order::join('customers', 'orders.outlet_id', '=', 'customers.outlet_id')
            ->select('orders.*', 'customers.address as customer_address', 'customers.nomor as customer_id', 'customers.no_telp as customer_phone')
            ->with(['orderDetails' => function ($query) {
                // Eager load the tax_type, qty_duz, qty_pak, qty_pcs from order_details
                $query->select('order_details.*', 'tax_type', 'qty_duz', 'qty_pak', 'qty_pcs');
            }, 'outlet', 'sales'])
            ->where('orders.id', $order_id)
            ->first();

        if (!$order) {
            // Handle case where the order is not found
            abort(404);
        }

        // Extract tax_type values from orderDetails and concatenate into a string
        $taxTypesString = implode(', ', $order->orderDetails->pluck('tax_type')->unique()->toArray());
        // dd($taxTypesString);

        // Format date when invoice printted
        $order->formatted_printed_at = now()->format('d/m/Y');

        // Calculate the total quantity
        $totalItem = $order->totalItem();

        if ($order->exp_date) {
            // Check if $order->exp_date is a string
            if (is_string($order->exp_date)) {
                // Convert the string to a DateTime object
                $expDate = new \DateTime($order->exp_date);
            } else {
                // Assume $order->exp_date is already a DateTime object
                $expDate = $order->exp_date;
            }

            // Format the date and assign it to $order->formatted_exp_date
            $order->formatted_exp_date = $expDate->format('d/m/Y');
        } else {
            $order->formatted_exp_date = null;
        }

        //Nilai PPN
        $total = $order->total;
        $total = $total / 1.11;
        $total = $total * 0.11;

        return view('pages.app.admin_sales.invoice-print', compact('order', 'taxTypesString', 'total', 'totalItem'));
    }

    public function updateDiscount(Request $request, $orderDetailId)
    {
        // dd($orderDetailId);
        // Validasi input sesuai kebutuhan
        $request->validate([
            'disc_atas' => 'nullable|numeric|min:0|max:100',
        ]);

        // Cari order detail berdasarkan ID
        $orderDetail = OrderDetail::findOrFail($orderDetailId);
        // dd($orderDetail);

        // Simpan nilai diskon atas dan harga awal sebelum diupdate
        $oldDiscount = $orderDetail->disc_atas;
        $initialPriceDuz = $orderDetail->price_duz;
        $initialPricePak = $orderDetail->price_pak;
        $initialPricePcs = $orderDetail->price_pcs;

        // Update nilai diskon atas pada order detail
        $orderDetail->update([
            'disc_atas' => $request->input('disc_atas'),
        ]);

        // Revert the discount if needed
        if ($oldDiscount !== null) {
            $revertedPriceDuz = $initialPriceDuz / (1 - $oldDiscount / 100);
            $revertedPricePak = $initialPricePak / (1 - $oldDiscount / 100);
            $revertedPricePcs = $initialPricePcs / (1 - $oldDiscount / 100);

            $orderDetail->update([
                'price_duz' => $revertedPriceDuz,
                'price_pak' => $revertedPricePak,
                'price_pcs' => $revertedPricePcs,
            ]);
        }

        // Hitung ulang total setelah diskon diterapkan pada setiap produk
        $order = Order::findOrFail($orderDetail->order_id);
        $order->calculateTotal();

        // Redirect atau kirim respons sesuai kebutuhan
        return redirect()->back()->with('success', 'Diskon atas berhasil diupdate.');
    }


    public function generateInvoice($order_id)
    {
        // Logika untuk mendapatkan data pesanan dan informasi faktur
        // $order

        // Generate PDF
        $pdf = Pdf::loadView('pages.app.admin_sales.invoice');

        // Download PDF
        return $pdf->download('invoice_' . $order_id . '.pdf');
    }
}
