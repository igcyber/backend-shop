<?php

namespace App\Imports;

use Log;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        // dd($row);
        // Skip empty rows
        if (empty(array_filter($row))) {
            return null;
        }
        info('Row Data:', $row);
        // Calculate 'pakPerDus' based on the Excel data
        $pakPerDus = $row['dus_pak'] * $row['pak_pcs'];

        // Check if 'without_pcs' is checked
        $withoutPcsChecked = isset($row['withoutpcs']) && $row['withoutpcs'] == '1';

        // Perform calculations based on whether 'without_pcs' is checked or not
        $hasil_perhitungan = $withoutPcsChecked
            ? countQtyWithoutPcs((int)$row['total_stock'], $pakPerDus)
            : countQty((int)$row['total_stock'], $pakPerDus, (int)$row['pak_pcs']);

        // Parse 'exp_date' using Carbon
        $row['exp_date'] = isset($row['exp_date']) && !empty($row['exp_date'])
            ? Carbon::parse($row['exp_date'])->format('Y-m-d')
            : null;

        // Add calculated values to the $row array
        $row['stock_duz'] = $hasil_perhitungan['jumlah_dus'];
        $row['stock_pak'] = $hasil_perhitungan['sisa_pak'];
        $row['stock_pcs'] = $hasil_perhitungan['sisa_biji'] ?? 0;

        // Create and return a new Product instance with the modified $row data
        return new Product([
            'category_id' => $row['category_id'],
            'vendor_id' => $row['vendor_id'],
            'serial_number' => $row['serial_number'],
            'image' => $row['image'],
            'title' => $row['title'],
            'short_description' => $row['short_description'],
            'dus_pak' => $row['dus_pak'],
            'pak_pcs' => $row['pak_pcs'],
            'withoutPcs' => $row['withoutpcs'],
            'total_stock' => $row['total_stock'],
            'stock_duz' => $row['stock_duz'],
            'stock_pak' => $row['stock_pak'],
            'stock_pcs' => $row['stock_pcs'],
            'exp_date' => $row['exp_date'],
        ]);
    }
}
