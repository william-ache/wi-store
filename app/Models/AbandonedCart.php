<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbandonedCart extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'shop_id',
        'customer_name',
        'customer_phone',
        'cart_data',
        'status',
    ];

    protected $casts = [
        'cart_data' => 'array',
    ];
}
