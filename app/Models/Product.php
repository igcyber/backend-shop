<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'vendor_id',
        'image',
        'serial_number',
        'title',
        'short_descriptions',
        'buy_price',
        'sell_price_duz',
        'sell_price_pack',
        'sell_price_pcs',
        'stock',
        'tax_type',
        'periode',
        'unit',
        'is_top'
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
}
