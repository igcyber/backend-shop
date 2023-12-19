<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function productDetail()
    {
        return $this->belongsTo(DetailProduct::class, 'detail_id');
    }

    public function calculateSubtotal()
    {
        $subtotal = 0;

        if ($this->qty_duz > 0) {
            $subtotal += $this->price_duz * $this->qty_duz;
        }

        if ($this->qty_pak > 0) {
            $subtotal += $this->price_pak * $this->qty_pak;
        }

        if ($this->qty_pcs > 0) {
            $subtotal += $this->price_pcs * $this->qty_pcs;
        }

        // Terapkan diskon atas jika ada
        if ($this->disc_atas > 0) {
            $subtotal -= ($subtotal * ($this->disc_atas / 100));

            // Update harga pada order_details setelah diskon
            $this->update([
                'price_duz' => $this->price_duz - ($this->price_duz * ($this->disc_atas / 100)),
                'price_pak' => $this->price_pak - ($this->price_pak * ($this->disc_atas / 100)),
                'price_pcs' => $this->price_pcs - ($this->price_pcs * ($this->disc_atas / 100)),
            ]);
        }

        return $subtotal;
    }
}
