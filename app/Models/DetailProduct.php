<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // public function sell_price_duz(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn ($value) => intval(str_replace(['Rp.', '.', ','], '', $value))
    //     );
    // }
}
