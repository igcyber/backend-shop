<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    // Allows mass assignment for all attributes
    protected $guarded = [];

    // Relationship with Order model - each order detail belongs to a single order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Relationship with DetailProduct model
    public function productDetail()
    {
        return $this->belongsTo(DetailProduct::class, 'detail_id');
    }

    // Calculate subtotal for the order detail
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

        // Add shipping cost to the subtotal
        $subtotal += $this->shipping_cost;


        // Apply disc_atas if exists
        if ($this->disc_atas > 0) {
            $subtotal -= ($subtotal * ($this->disc_atas / 100));

            //update price each units i.e (price_duz, price_pak, price_pcs)
            $this->update([
                'price_duz' => $this->price_duz - ($this->price_duz * ($this->disc_atas / 100)),
                'price_pak' => $this->price_pak - ($this->price_pak * ($this->disc_atas / 100)),
                'price_pcs' => $this->price_pcs - ($this->price_pcs * ($this->disc_atas / 100)),
            ]);
        }



        return $subtotal;
    }
}
