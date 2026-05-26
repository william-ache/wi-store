<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlatformTestimonial extends Model
{
    protected $fillable = [
        'shop_id',
        'user_id',
        'rating',
        'title',
        'comment',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function forLanding(): \Illuminate\Support\Collection
    {
        return static::query()
            ->where('is_published', true)
            ->with(['shop:id,name,slug,logo_path,cover_path,cover_webp_path,logo_webp_path'])
            ->orderByDesc('rating')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (self $item) => [
                'id' => $item->id,
                'rating' => $item->rating,
                'title' => $item->title,
                'comment' => $item->comment,
                'shop_name' => $item->shop?->name ?? 'Comercio WI-Store',
                'shop_slug' => $item->shop?->slug,
                'shop_logo' => $item->shop?->logoUrl()
                    ?? 'https://ui-avatars.com/api/?name=' . urlencode($item->shop?->name ?? 'W') . '&background=a855f7&color=fff',
                'shop_cover' => $item->shop?->coverUrl(),
                'created_at' => $item->created_at?->format('M Y'),
            ]);
    }
}
