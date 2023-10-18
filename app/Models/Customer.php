<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'klasifikasi',
        'nomor',
        'user_id',
        'no_telp',
        'address',
    ];

    /**
     * Belongs to Relationship model with User model
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
