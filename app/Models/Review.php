<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = ['shop_id', 'customer_name', 'rating', 'comment', 'is_approved'];
}
