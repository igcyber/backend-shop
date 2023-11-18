<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

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
}
