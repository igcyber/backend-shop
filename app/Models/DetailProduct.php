<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'buy_price',
        'sell_price_duz',
        'sell_price_pack',
        'sell_price_pcs',
        'tax_type',
        'periode',
        'is_top'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
