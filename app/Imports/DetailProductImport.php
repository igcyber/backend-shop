<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\DetailProduct;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DetailProductImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);

        // Skip empty rows
        if (empty(array_filter($row))) {
            return null;
        }
        // info('Row Data:', $row);

        $productContent = Product::findOrFail($row['product_id']);
        $sell_price_duz = $row['sell_price_duz'];

        if ($productContent->withoutpcs == 0) {
            // If withoutPcs is equal to 0
            $getPricePak = $sell_price_duz / $productContent->dus_pak;
            $getPricePcs = $getPricePak / $productContent->pak_pcs;
        } elseif ($productContent->withoutpcs == 1) {
            // If withoutPcs is equal to 1
            $getPricePak = $sell_price_duz / $productContent->pak_pcs;
            // Adjust $getPricePcs accordingly if needed
        }

        // Use the 'discount' field from the request
        $discountPercentage = $row['discount'];

        // Apply the discount if it's provided
        if ($discountPercentage !== null) {
            $discountMultiplier = 1 - ($discountPercentage / 100);
            $sell_price_duz *= $discountMultiplier;
            $getPricePak *= $discountMultiplier;
            $getPricePcs *= $discountMultiplier ?? 0;
        }

        return new DetailProduct([
            //row input
            'sales_id' => $row['sales_id'],
            'product_id' => $row['product_id'],
            'sell_price_duz' => $sell_price_duz,
            'sell_price_pak' => $getPricePak,
            'sell_price_pcs' => $getPricePcs ?? 0,
            'tax_type' => $row['tax_type'],
            'periode' => $row['periode'],
            'discount' => $row['discount']
        ]);
    }
}
