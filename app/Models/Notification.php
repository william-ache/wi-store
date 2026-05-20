<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = ['shop_id', 'title', 'content', 'type', 'is_read'];

    protected $casts = [
        'is_read' => 'boolean'
    ];

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        // Enforce maximum of 100 notifications per shop (FIFO)
        static::created(function ($notification) {
            $shopId = $notification->shop_id;
            
            // Query without global scopes to ensure absolute count is checked and trimmed
            $count = self::withoutGlobalScopes()->where('shop_id', $shopId)->count();
            if ($count > 100) {
                $excess = $count - 100;
                $oldestIds = self::withoutGlobalScopes()
                    ->where('shop_id', $shopId)
                    ->orderBy('id', 'asc')
                    ->limit($excess)
                    ->pluck('id');
                
                self::withoutGlobalScopes()->whereIn('id', $oldestIds)->delete();
            }
        });
    }
}
