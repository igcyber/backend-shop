<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_id');
    }

    public function outlet()
    {
        return $this->belongsTo(User::class, 'outlet_id');
    }

    // Calculate Total Overall
    public function calculateTotal()
    {
        $total = 0;

        foreach ($this->orderDetails as $orderDetail) {
            $total += $orderDetail->calculateSubtotal();
        }

        // Terapkan diskon bawah jika ada
        if ($this->disc_bawah > 0) {
            $total -= ($total * ($this->disc_bawah / 100));
        }

        $this->total = $total;
        $this->save();
    }
}
