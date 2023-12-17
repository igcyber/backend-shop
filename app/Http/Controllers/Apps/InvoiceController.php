<?php

namespace App\Http\Controllers\Apps;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function showInvoice($order_id)
    {
        $order = Order::join('customers', 'orders.outlet_id', '=', 'customers.outlet_id')
            ->select('orders.*', 'customers.address as customer_address', 'customers.nomor as customer_id', 'customers.no_telp as customer_phone')
            ->with(['orderDetails', 'outlet', 'sales'])
            ->where('orders.id', $order_id)
            ->first();

        if (!$order) {
            // Handle case where the order is not found
            abort(404);
        }

        // Format the created_at date
        $order->formatted_created_at = $order->created_at->format('d/m/Y');

        return view('pages.app.admin_sales.invoice-show', compact('order'));
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
