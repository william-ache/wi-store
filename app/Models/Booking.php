<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'shop_id',
        'client_name',
        'client_phone',
        'date',
        'time_slot',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
