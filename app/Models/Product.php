<?php

namespace App\Models;

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
        'is_available',
        'features',
        'preparation_time'
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
