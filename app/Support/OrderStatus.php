<?php

namespace App\Support;

class OrderStatus
{
    public const PENDING = 'pending';

    public const COLLECTED = 'collected';

    public const PREPARING = 'preparing';

    public const READY = 'ready';

    public const DELIVERED = 'delivered';

    public const CANCELLED = 'cancelled';

    /** @return array<string, string> */
    public static function labels(): array
    {
        return [
            self::PENDING => 'Pendiente',
            self::COLLECTED => 'Cobrado',
            self::PREPARING => 'En preparación',
            self::READY => 'Listo',
            self::DELIVERED => 'Entregado',
            self::CANCELLED => 'Cancelado',
        ];
    }

    /** @return list<string> */
    public static function keys(): array
    {
        return array_keys(self::labels());
    }

  /** @return array<string, array{label: string, badge: string}> */
    public static function meta(): array
    {
        $badges = [
            self::PENDING => 'bg-amber-100 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 border-amber-200/30',
            self::COLLECTED => 'bg-teal-100 dark:bg-teal-950/60 text-teal-600 dark:text-teal-400 border-teal-200/30',
            self::PREPARING => 'bg-blue-100 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 border-blue-200/30',
            self::READY => 'bg-lime-100 dark:bg-lime-950/60 text-lime-700 dark:text-lime-400 border-lime-200/30',
            self::DELIVERED => 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border-emerald-200/30',
            self::CANCELLED => 'bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 border-rose-200/30',
        ];

        $meta = [];
        foreach (self::labels() as $key => $label) {
            $meta[$key] = [
                'label' => $label,
                'badge' => $badges[$key],
            ];
        }

        return $meta;
    }

    public static function label(?string $status): string
    {
        return self::labels()[$status] ?? (string) $status;
    }

    public static function badgeClass(?string $status): string
    {
        return self::meta()[$status]['badge'] ?? 'bg-slate-100 text-slate-600 border-slate-200/30';
    }

    public static function isValid(?string $status): bool
    {
        return $status !== null && array_key_exists($status, self::labels());
    }
}
