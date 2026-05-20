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
        'google_maps_link', 'work_hours', 'base_currency',
        'delivery_rate_per_km', 'latitude', 'longitude'
    ];

    protected $casts = [
        'work_hours' => 'array',
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
