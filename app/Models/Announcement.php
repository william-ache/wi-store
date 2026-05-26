<?php

namespace App\Models;

use App\Support\MediaUrl;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'shop_id',
        'title',
        'content',
        'image_path',
        'image_webp_path',
        'image_width',
        'image_height',
        'button_text',
        'button_link',
        'expires_at',
        'is_active',
    ];

    protected $appends = [
        'image_url',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'date',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return MediaUrl::displayUrl($this->image_path, $this->image_webp_path);
    }
}
