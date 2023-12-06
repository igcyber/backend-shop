<?php

use App\Models\Order;
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

if (!function_exists('getInvoiceNumber')) {
    function getInvoiceNumber()
    {
        $month = date('m');
        $year = date('Y');
        $totalTransactions = DB::table('orders')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count() + 10569;
        return $totalTransactions . "-{$month}-{$year}";
    }
}

if (!function_exists('getUniqueTransactionId')) {
    function getUniqueTransactionId()
    {
        $maxAttempts = 3;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                $transactionId = getInvoiceNumber();

                if (!Order::where('transaction_id', $transactionId)->exists()) {
                    return $transactionId;
                }
            } catch (\Exception $e) {
                // Log or handle the exception if needed
            }
        }

        throw new \Exception('Failed to generate a unique transaction_id after ' . $maxAttempts . ' attempts.');
    }
}

if (!function_exists('countQty')) {
    function countQty($totalBiji, $bijiPerDus, $bijiPerPak)
    {
        // Hitung jumlah dus yang dibutuhkan
        $jumlahDus = floor($totalBiji / $bijiPerDus);

        // Hitung sisa biji setelah mengambil dus
        $sisaBiji = $totalBiji - ($jumlahDus * $bijiPerDus);

        // Hitung sisa pak jika ada
        $sisaPak = floor($sisaBiji / $bijiPerPak);

        //Hitung sisa biji dari pak
        $sisaBijiAkhir = $sisaBiji - ($sisaPak * $bijiPerPak);

        return [
            'jumlah_dus' => $jumlahDus,
            'sisa_pak' => $sisaPak,
            'sisa_biji' => $sisaBijiAkhir,
        ];
    }
}

if (!function_exists('countQtyWithoutPcs')) {
    function countQtyWithoutPcs($totalBiji, $pakPerDus)
    {
        // Hitung jumlah dus yang dibutuhkan
        $jumlahDus = floor($totalBiji / $pakPerDus);

        // Hitung sisa pak jika ada
        $sisaPak = $totalBiji % $pakPerDus;

        return [
            'jumlah_dus' => $jumlahDus,
            'sisa_pak' => $sisaPak,
        ];
    }
}
