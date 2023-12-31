<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (empty(array_filter($row))) {
            return null;
        }

        return new Customer([
            'klasifikasi' => $row['klasifikasi'],
            'nomor' => $row['nomor'] ?? "-",
            'outlet_id' => $row['outlet_id'],
            'sales_id' => $row['sales_id'],
            'no_telp' => $row['no_telp'],
            'address' => $row['address'],
            'hrg_jual' => $row['hrg_jual'],
        ]);
    }
}
