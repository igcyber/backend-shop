<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'No.Urut',
            'Tipe',
            'Pabrikan',
            'Serial Number',
            'Gambar',
            'Nama',
            'Keterangan',
            'Total',
            'Stok Dus',
            'Stok Pak',
            'Stok Pcs',
            'Tgl. Kadaluarsa'
        ];
    }

    public function map($row): array
    {
        static $counter = 1; // Initialize a static counter variable
        return [
            $counter++,
            $row->category->name,
            $row->vendor->name,
            $row->serial_number,
            $row->image ? 'Gambar Produk' : '',
            $row->title,
            $row->short_description,
            $row->total_stock,
            $row->stock_duz,
            $row->stock_pak,
            $row->stock_pcs,
            $row->exp_date
        ];
    }
}
