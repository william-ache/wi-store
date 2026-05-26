<?php

namespace App\Support;

final class MediaUrl
{
    public static function fromPath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    /** URL pública priorizando WebP para rutas locales. */
    public static function displayUrl(?string $path, ?string $webpPath = null): ?string
    {
        if (!$path) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return self::fromPath($webpPath) ?? self::fromPath($path);
    }
}
