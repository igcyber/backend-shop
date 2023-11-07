<?php

use Illuminate\Support\Facades\DB;


if (!function_exists('moneyFormat')) {
    /**
     * This function is used to format the money in Indonesia Currency format
     *
     * @param mixed $str
     * @return void
     */
    function moneyFormat($str)
    {
        return 'Rp. ' . number_format($str, '0', '', '.');
    }
}

if (!function_exists('dateID')) {

    function dateID($tanggal)
    {
        $value = Carbon\Carbon::parse($tanggal);
        $parse = $value->locale('id');
        return $parse->translatedFormat('l, d F Y');
    }
}

if (!function_exists('setActive')) {
    function setActive(array $route)
    {
        if (is_array($route)) {
            foreach ($route as $r) {
                if (request()->routeIs($r)) {
                    return 'active';
                }
            }
        }
    }
}

// Get Total Amount In Cart
if (!function_exists('getCartTotal')) {
    function getCartTotal()
    {
        $total = 0;
        foreach (\Cart::content() as $product) {
            $total += ($product->price * $product->qty);
        }
        return $total;
    }
}

if (!function_exists('getInvoiceNumber')) {
    function getInvoiceNumber()
    {
        $month = date('m');
        $year = date('Y');
        $totalTransactions = DB::table('orders')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count() + 10569;
        $invoiceNumber = $totalTransactions . "-{$month}-{$year}";

        return $invoiceNumber;
    }
}

if (!function_exists('clearCart')) {
    function clearCart()
    {
        \Cart::destroy();
    }
}
