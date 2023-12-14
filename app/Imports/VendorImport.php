<?php

namespace App\Imports;

use App\Models\Vendor;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VendorImport implements ToModel,  WithHeadingRow
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

        $slug =  Str::slug($row['name']);

        return new Vendor([
            'name' => $row['name'],
            'status' => 1,
            'slug' => $slug,

        ]);
    }
}
