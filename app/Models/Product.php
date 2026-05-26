<?php

namespace App\Models;

use App\Support\MediaUrl;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'shop_id',
        'category_id',
        'name',
        'seo_title',
        'seo_description',
        'description',
        'price',
        'image_path',
        'image_webp_path',
        'image_width',
        'image_height',
        'is_available',
        'features',
        'preparation_time',
    ];

    protected $appends = [
        'image_url',
        'image_webp_url',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return MediaUrl::fromPath($this->image_path);
    }

    public function getImageWebpUrlAttribute(): ?string
    {
        return MediaUrl::fromPath($this->image_webp_path);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
