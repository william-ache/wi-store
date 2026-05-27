<?php

namespace App\Support;

final class PlanTrial
{
    public static function days(): int
    {
        return (int) config('wi-store.trial_days', 14);
    }

    public static function disclaimer(): string
    {
        return sprintf(
            'Sin cobros adicionales, ni pago. Totalmente gratis los %d días.',
            self::days()
        );
    }

    public static function label(): string
    {
        return self::days() . ' días gratis';
    }

    public static function shortLabel(): string
    {
        return self::days() . ' días';
    }
}
