<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'shop_id', 'client_id', 'order_number', 'customer_name', 'customer_phone', 'total', 'status', 'payment_method', 'payment_status', 'table_number', 'delivery_type', 'payment_reference'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
