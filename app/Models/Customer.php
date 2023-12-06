<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'klasifikasi',
        'nomor',
        'sales_id',
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
        return $this->belongsTo(User::class, 'sales_id');
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
