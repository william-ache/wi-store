<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class ImageOptimizer
{
    public function storeProductImage(UploadedFile $file): array
    {
        return $this->mapKeys($this->storeInDirectory($file, 'products'), 'image');
    }

    public function storeAnnouncementImage(UploadedFile $file): array
    {
        return $this->mapKeys($this->storeInDirectory($file, 'announcements'), 'image');
    }

    public function storeLogoImage(UploadedFile $file): array
    {
        return $this->mapKeys($this->storeInDirectory($file, 'logos'), 'logo');
    }

    public function storeCoverImage(UploadedFile $file): array
    {
        return $this->mapKeys($this->storeInDirectory($file, 'covers'), 'cover');
    }

    public function deleteStoredImages(?string $imagePath, ?string $webpPath = null): void
    {
        $disk = Storage::disk('public');

        foreach (array_filter([$imagePath, $webpPath]) as $path) {
            if ($disk->exists($path)) {
                $disk->delete($path);
            }
        }
    }

    /** @deprecated Use deleteStoredImages() */
    public function deleteProductImages(?string $imagePath, ?string $webpPath = null): void
    {
        $this->deleteStoredImages($imagePath, $webpPath);
    }

    public function regenerateWebpFromPath(string $storagePath): ?string
    {
        $disk = Storage::disk('public');
        if (!$disk->exists($storagePath)) {
            return null;
        }

        $webpPath = preg_replace('/\.[^.]+$/', '.webp', $storagePath);
        if ($this->convertToWebp($disk->path($storagePath), $disk->path($webpPath))) {
            return $webpPath;
        }

        return null;
    }

    public function dimensionsForPath(string $storagePath): array
    {
        $disk = Storage::disk('public');
        if (!$disk->exists($storagePath)) {
            return ['width' => null, 'height' => null];
        }

        $size = @getimagesize($disk->path($storagePath));

        return [
            'width' => $size[0] ?? null,
            'height' => $size[1] ?? null,
        ];
    }

    /**
     * @return array{path: string, webp_path: ?string, width: ?int, height: ?int}
     */
    private function storeInDirectory(UploadedFile $file, string $directory): array
    {
        $basename = Str::random(40);
        $extension = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $extension = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true) ? $extension : 'jpg';

        $originalPath = "{$directory}/{$basename}.{$extension}";
        Storage::disk('public')->putFileAs($directory, $file, "{$basename}.{$extension}");

        $absolute = Storage::disk('public')->path($originalPath);
        $size = @getimagesize($absolute);
        $width = $size[0] ?? null;
        $height = $size[1] ?? null;

        $webpPath = "{$directory}/{$basename}.webp";
        $webpAbsolute = Storage::disk('public')->path($webpPath);
        $webpStored = $this->convertToWebp($absolute, $webpAbsolute);

        return [
            'path' => $originalPath,
            'webp_path' => $webpStored ? $webpPath : null,
            'width' => $width,
            'height' => $height,
        ];
    }

    /**
     * @param  array{path: string, webp_path: ?string, width: ?int, height: ?int}  $result
     */
    private function mapKeys(array $result, string $prefix): array
    {
        return [
            "{$prefix}_path" => $result['path'],
            "{$prefix}_webp_path" => $result['webp_path'],
            "{$prefix}_width" => $result['width'],
            "{$prefix}_height" => $result['height'],
        ];
    }

    private function convertToWebp(string $source, string $destination): bool
    {
        if (!function_exists('imagewebp')) {
            return false;
        }

        $image = $this->loadImage($source);
        if (!$image) {
            return false;
        }

        if (function_exists('imagepalettetotruecolor')) {
            imagepalettetotruecolor($image);
        }
        imagealphablending($image, true);
        imagesavealpha($image, true);

        $ok = imagewebp($image, $destination, 82);
        imagedestroy($image);

        return $ok && is_file($destination);
    }

    private function loadImage(string $path)
    {
        $info = @getimagesize($path);
        if (!$info) {
            return false;
        }

        return match ($info[2]) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($path),
            IMAGETYPE_PNG => @imagecreatefrompng($path),
            IMAGETYPE_GIF => @imagecreatefromgif($path),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            default => false,
        };
    }
}
