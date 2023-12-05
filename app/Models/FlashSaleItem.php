<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function detailProduct()
    {
        return $this->belongsTo(DetailProduct::class, 'detail_id');
    }

    public function flashSale()
    {
        return $this->belongsTo(FlashSale::class, 'flash_id');
    }
}
