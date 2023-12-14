<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sell_price_duz',
        'sell_price_pak',
        'sell_price_pcs',
        'tax_type',
        'periode',
        'discount'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
