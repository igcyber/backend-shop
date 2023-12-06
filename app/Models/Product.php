<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];


    protected $casts = [
        'is_checked' => 'boolean',
    ];


    /**
     * Belongs to Relationship model with category model
     *
     * @return void
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function detailProduct()
    {
        return $this->hasOne(DetailProduct::class, 'product_id');
    }

    /**
     * Belongs to Relationship model with vendor model
     *
     * @return void
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Accesor Image
     *
     * @return Attribute
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/products/' . $value),
        );
    }

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value)
        );
    }

    public function decrementStock($duz, $pak, $pcs)
    {

        // Check if $duz is equal to 0 or empty
        if ($duz === 0 || empty($duz)) {
            // If $duz is 0 or empty, decrement total_stock using $pak value
            $this->decrement('total_stock', $pak);
        } else {
            // If $duz has a value, decrement total_stock using $duz value
            $this->decrement('total_stock', $duz);
        }

        // If $pcs has a value, decrement total_stock using $pcs value
        $this->decrement('total_stock', $pcs);


        //How much pcs/Duz
        $pcsPerDuz = $this->dus_pak * $this->pak_pcs;

        // Calculate remaining quantities using the global helper function
        $finalQty = countQty($this->total_stock, $pcsPerDuz, $this->pak_pcs);

        // Update the remaining quantities in the product table
        $this->update([
            'stock_duz' => $finalQty['jumlah_dus'],
            'stock_pak' => $finalQty['sisa_pak'],
            'stock_pcs' => $finalQty['sisa_biji'],
        ]);

        // Return the updated product instance
        return $this;
    }


    public function decStockPack($quantityInDuz, $quantityInPak)
    {
        // Check if $duz is equal to 0 or empty
        if ($quantityInDuz === 0 || empty($quantityInDuz)) {
            // If $duz is 0 or empty, decrement total_stock using $pak value
            $this->decrement('total_stock', $quantityInPak);
        } else {
            // If $duz has a value, decrement total_stock using $duz value
            $this->decrement('total_stock', $quantityInDuz);
        }

        // Calculate the conversion factor for dus to pak to pcs
        $packPerDuz = $this->dus_pak * $this->pak_pcs;

        // Calculate remaining quantities using the global helper function
        $remainingQuantities = countQtyWithoutPcs($this->total_stock, $packPerDuz);

        // Update the remaining quantities in the product table
        $this->update([
            'stock_duz' => $remainingQuantities['jumlah_dus'],
            'stock_pak' => $remainingQuantities['sisa_pak']
        ]);

        // Return the updated product instance
        return $this;
    }
}
