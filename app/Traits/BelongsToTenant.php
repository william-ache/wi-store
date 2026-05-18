<?php

namespace App\Traits;

use App\Models\Scopes\TenantScope;

trait BelongsToTenant
{
    public static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function ($model) {
            if (config('current_shop_id') && !$model->shop_id) {
                $model->shop_id = config('current_shop_id');
            }
        });
    }

    public function shop()
    {
        return $this->belongsTo(\App\Models\Shop::class);
    }
}
