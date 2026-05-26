<?php

namespace App\Support;

class BrandColor
{
    public const ON_DARK = '#FFFFFF';

    public const ON_LIGHT = '#1F2937';

    /** Umbral WCAG: luminancia relativa por debajo de la cual el acento se considera oscuro. */
    public const LUMINANCE_THRESHOLD = 0.179;

    public static function normalizeHex(string $hex): string
    {
        $hex = ltrim(trim($hex), '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        if (! preg_match('/^[0-9A-Fa-f]{6}$/', $hex)) {
            return '#E60067';
        }

        return '#'.strtoupper($hex);
    }

    /**
     * @return array{r: int, g: int, b: int}
     */
    public static function rgb(string $hex): array
    {
        $hex = ltrim(self::normalizeHex($hex), '#');

        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2)),
        ];
    }

    public static function relativeLuminance(string $hex): float
    {
        $rgb = self::rgb($hex);
        $channels = [];

        foreach (['r', 'g', 'b'] as $channel) {
            $value = $rgb[$channel] / 255;
            $channels[] = $value <= 0.03928
                ? $value / 12.92
                : pow(($value + 0.055) / 1.055, 2.4);
        }

        return 0.2126 * $channels[0] + 0.7152 * $channels[1] + 0.0722 * $channels[2];
    }

    public static function isDark(string $hex): bool
    {
        return self::relativeLuminance($hex) <= self::LUMINANCE_THRESHOLD;
    }

    public static function onPrimary(string $hex): string
    {
        return self::isDark($hex) ? self::ON_DARK : self::ON_LIGHT;
    }

    /**
     * @return array{r: int, g: int, b: int}
     */
    public static function onPrimaryRgb(string $hex): array
    {
        return self::rgb(self::onPrimary($hex));
    }
}
