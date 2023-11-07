<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'klasifikasi',
        'nomor',
        'seller_id',
        'outlet_id',
        'no_telp',
        'address',
    ];

    /**
     * Belongs to Relationship model with User model
     *
     * @return void
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Belongs to Relationship model with User model
     *
     * @return void
     */
    public function outlet()
    {
        return $this->belongsTo(User::class, 'outlet_id');
    }
}
