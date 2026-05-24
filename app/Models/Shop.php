<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'shop_category', 'shop_category_icon', 'whatsapp_number', 'description', 'address',
        'payment_methods', 'logo_path', 'cover_path', 'color_primary',
        'color_secondary', 'color_background', 'exchange_rate', 'exchange_updated_at',
        'google_maps_link', 'work_hours', 'base_currency', 'plan', 'billing_cycle',
        'plan_expires_at', 'last_payment_date', 'last_payment_amount', 'active_session_id',
        'pending_plan', 'pending_billing_cycle', 'payment_status', 'payment_reference',
        'payment_receipt_path', 'payment_submitted_at', 'payment_company_name', 'payment_company_email',
        'delivery_rate_per_km', 'latitude', 'longitude',
        'facebook', 'instagram', 'tiktok', 'x_twitter',
        'contact_phone', 'contact_sms', 'telegram', 'is_active',
        'has_dine_in', 'has_pickup', 'has_delivery', 'amenities',
        'enable_free_shipping', 'free_shipping_min_amount',
        'enabled_modules', 'has_setup_modules'
    ];

    protected $attributes = [
        'enabled_modules' => '["categories", "products", "orders", "clients", "announcements"]',
        'has_setup_modules' => false,
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
        'payment_submitted_at' => 'datetime',
        'enable_free_shipping' => 'boolean',
        'free_shipping_min_amount' => 'decimal:2',
        'enabled_modules' => 'array',
        'has_setup_modules' => 'boolean',
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
