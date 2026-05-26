<?php

namespace App\Console\Commands;

use App\Models\Announcement;
use App\Models\Product;
use App\Models\Shop;
use App\Services\ImageOptimizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OptimizeProductImages extends Command
{
    protected $signature = 'products:optimize-images
                            {--shop= : ID de tienda (solo productos y anuncios)}
                            {--shops : Incluir logos y portadas de tiendas}
                            {--announcements : Incluir imágenes de anuncios}
                            {--all : Productos, anuncios y branding de tiendas}';

    protected $description = 'Genera WebP y dimensiones para imágenes existentes';

    public function handle(ImageOptimizer $optimizer): int
    {
        $runAll = (bool) $this->option('all');
        $runShops = $runAll || (bool) $this->option('shops');
        $runAnnouncements = $runAll || (bool) $this->option('announcements');
        $runProducts = $runAll || (!$runShops && !$runAnnouncements);

        $shopId = $this->option('shop');
        $total = 0;

        if ($runProducts) {
            $total += $this->optimizeProducts($optimizer, $shopId);
        }

        if ($runAnnouncements) {
            $total += $this->optimizeAnnouncements($optimizer, $shopId);
        }

        if ($runShops) {
            $total += $this->optimizeShops($optimizer, $shopId);
        }

        $this->info("Registros optimizados: {$total}");

        return self::SUCCESS;
    }

    private function optimizeProducts(ImageOptimizer $optimizer, ?string $shopId): int
    {
        $query = Product::query()->whereNotNull('image_path');
        if ($shopId) {
            $query->where('shop_id', $shopId);
        }

        return $this->processPaths($query, $optimizer, function ($model, $webpPath, $dims) {
            $model->update([
                'image_webp_path' => $webpPath,
                'image_width' => $dims['width'],
                'image_height' => $dims['height'],
            ]);
        }, 'image_path', 'image_webp_path', 'image_width');
    }

    private function optimizeAnnouncements(ImageOptimizer $optimizer, ?string $shopId): int
    {
        $query = Announcement::query()->whereNotNull('image_path');
        if ($shopId) {
            $query->where('shop_id', $shopId);
        }

        return $this->processPaths($query, $optimizer, function ($model, $webpPath, $dims) {
            $model->update([
                'image_webp_path' => $webpPath,
                'image_width' => $dims['width'],
                'image_height' => $dims['height'],
            ]);
        }, 'image_path', 'image_webp_path', 'image_width');
    }

    private function optimizeShops(ImageOptimizer $optimizer, ?string $shopId): int
    {
        $query = Shop::query()->where(function ($q) {
            $q->whereNotNull('logo_path')->orWhereNotNull('cover_path');
        });

        if ($shopId) {
            $query->where('id', $shopId);
        }

        $count = 0;
        $disk = Storage::disk('public');

        $query->chunkById(25, function ($shops) use ($optimizer, $disk, &$count) {
            foreach ($shops as $shop) {
                $updates = [];

                foreach ([
                    ['path' => 'logo_path', 'webp' => 'logo_webp_path', 'w' => 'logo_width', 'h' => 'logo_height'],
                    ['path' => 'cover_path', 'webp' => 'cover_webp_path', 'w' => 'cover_width', 'h' => 'cover_height'],
                ] as $field) {
                    $path = $shop->{$field['path']};
                    if (!$path || filter_var($path, FILTER_VALIDATE_URL) || !$disk->exists($path)) {
                        continue;
                    }
                    if ($shop->{$field['webp']} && $shop->{$field['w']}) {
                        continue;
                    }

                    $dims = $optimizer->dimensionsForPath($path);
                    $updates[$field['webp']] = $optimizer->regenerateWebpFromPath($path);
                    $updates[$field['w']] = $dims['width'];
                    $updates[$field['h']] = $dims['height'];
                    $count++;
                }

                if ($updates) {
                    $shop->update($updates);
                }
            }
        });

        return $count;
    }

    private function processPaths($query, ImageOptimizer $optimizer, callable $update, string $pathKey, string $webpKey, string $widthKey): int
    {
        $count = 0;
        $disk = Storage::disk('public');

        $query->chunkById(50, function ($models) use ($optimizer, $disk, &$count, $update, $pathKey, $webpKey, $widthKey) {
            foreach ($models as $model) {
                if ($model->{$webpKey} && $model->{$widthKey}) {
                    continue;
                }

                $path = $model->{$pathKey};
                if (!$path || !$disk->exists($path)) {
                    continue;
                }

                $dims = $optimizer->dimensionsForPath($path);
                $webpPath = $optimizer->regenerateWebpFromPath($path);
                $update($model, $webpPath, $dims);
                $count++;
            }
        });

        return $count;
    }
}
