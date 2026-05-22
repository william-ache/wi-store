<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'whatsapp_number', 'description', 'address',
        'payment_methods', 'logo_path', 'cover_path', 'color_primary',
        'color_secondary', 'color_background', 'exchange_rate', 'exchange_updated_at',
        'google_maps_link', 'work_hours', 'base_currency', 'plan', 'billing_cycle',
        'plan_expires_at', 'last_payment_date', 'last_payment_amount', 'active_session_id',
        'delivery_rate_per_km', 'latitude', 'longitude',
        'facebook', 'instagram', 'tiktok', 'x_twitter',
        'contact_phone', 'contact_sms', 'telegram', 'is_active',
        'has_dine_in', 'has_pickup', 'has_delivery', 'amenities'
    ];

    protected $casts = [
        'work_hours' => 'array',
        'is_active' => 'boolean',
        'has_dine_in' => 'boolean',
        'has_pickup' => 'boolean',
        'has_delivery' => 'boolean',
        'amenities' => 'array',
        'plan_expires_at' => 'date',
        'last_payment_date' => 'date',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function shortLinks()
    {
        return $this->hasMany(ShortLink::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
