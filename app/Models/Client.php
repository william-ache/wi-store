<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'shop_id', 'name', 'phone', 'email', 'total_spent', 'status'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
