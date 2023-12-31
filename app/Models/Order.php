<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Allows mass assignment for all attributes
    protected $guarded = [];

    // Relationship with OrderDetail model - a single order can have multiple order details
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    // Relationship with User model for sales
    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_id');
    }

    // Relationship with User model for outlet
    public function outlet()
    {
        return $this->belongsTo(User::class, 'outlet_id');
    }

    // Calculate total overall for the order
    public function calculateTotal()
    {
        $total = 0;

        foreach ($this->orderDetails as $orderDetail) {
            $total += $orderDetail->calculateSubtotal();
        }

        // Apply disc_bawah if exists
        if ($this->disc_bawah > 0) {
            $total -= ($total * ($this->disc_bawah / 100));
        }

        // Add shipping cost to the total
        $total += $this->orderDetails->sum('shipping_cost');

        $this->total = $total;
        $this->save();
    }

    // Calculate the total number of items in the order
    public function totalItem()
    {
        return $this->orderDetails->sum('qty_duz') + $this->orderDetails->sum('qty_pak') + $this->orderDetails->sum('qty_pcs');
    }
}
