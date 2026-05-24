<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory, BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'shop_id',
        'code',
        'type',
        'value',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'expires_at',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
    ];

    /**
     * Validate coupon eligibility for a given purchase subtotal.
     *
     * @param float $subtotal
     * @return array
     */
    public function validateForAmount($subtotal)
    {
        if (!$this->is_active) {
            return [
                'valid' => false,
                'message' => 'El cupón ingresado no está activo.'
            ];
        }

        if ($this->expires_at && now()->isAfter($this->expires_at)) {
            return [
                'valid' => false,
                'message' => 'El cupón ha expirado.'
            ];
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return [
                'valid' => false,
                'message' => 'Este cupón ya alcanzó el límite máximo de usos.'
            ];
        }

        if ($subtotal < $this->min_order_amount) {
            return [
                'valid' => false,
                'message' => 'El subtotal mínimo de compra requerido es $' . number_format($this->min_order_amount, 2) . '.'
            ];
        }

        return ['valid' => true];
    }
}
