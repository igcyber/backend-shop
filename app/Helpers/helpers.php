<?php

use App\Models\User;
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


// Helper function to get count for the current month and year
if (!function_exists('getCountForMonthYear')) {
    function getCountForMonthYear()
    {
        $month = date('m');
        $year = date('Y');

        return DB::table('orders')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
    }
}


if (!function_exists('getInvoiceNumber')) {
    function getInvoiceNumber()
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            $month = date('m');
            $year = date('Y');

            // Lock the orders table to prevent concurrent reads
            DB::table('orders')->lockForUpdate()->get();

            // Get the count of orders for the current month and year
            $totalTransactions = getCountForMonthYear();
            // Increment the count
            $totalTransactions++;

            // Update the count in the database
            DB::table('orders')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->update(['total_transactions' => $totalTransactions]);

            // Commit the transaction
            DB::commit();

            // return $totalTransactions . "-{$month}-{$year}";
            return $totalTransactions . "-" . date('m') . "-" . date('Y');
        } catch (\Exception $e) {
            // Roll back the transaction in case of an exception
            DB::rollBack();

            // Log or handle the exception if needed
            // ...

            // Re-throw the exception
            throw $e;
        }
    }
}

if (!function_exists('getUniqueTransactionId')) {
    function getUniqueTransactionId()
    {
        $maxAttempts = 3;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                return DB::transaction(function () {
                    $transactionId = getInvoiceNumber();

                    if (!Order::where('transaction_id', $transactionId)->exists()) {
                        return $transactionId;
                    }

                    // If the transaction ID already exists, throw an exception
                    throw new \Exception('Transaction ID already exists.');
                });
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
        // Ensure that $bijiPerDus and $bijiPerPak are not zero to avoid division by zero
        $bijiPerDus = max($bijiPerDus, 1);
        $bijiPerPak = max($bijiPerPak, 1);

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
        // Ensure that $pakPerDus is not zero to avoid division by zero
        $pakPerDus = max($pakPerDus, 1);

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

if (!function_exists('generateUsername')) {
    function generateUsername($name)
    {
        // Remove spaces, '/', '(', and ')' from the name
        $cleanedName = str_replace([' ', '/', '(', ')', '.'], '', $name);

        // Take the first four characters
        $baseUsername = strtolower(substr($cleanedName, 0, 4));

        // Generate three random characters
        $randomChars = str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789');
        $randomChars = substr($randomChars, 0, 3);

        // Combine the base username and random characters
        return $baseUsername . '-' . $randomChars;
    }
}
