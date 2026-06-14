<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('resolve_image_url')) {
    /**
     * Resolve image URL from various path formats.
     * Returns placeholder ONLY if file genuinely doesn't exist.
     *
     * @param string|null $path
     * @param string|null $fallback
     * @return string
     */
    function resolve_image_url(?string $path, ?string $fallback = null): string
    {
        $fallback = $fallback ?? asset('images/placeholder-kos.png');

        if ($path === null || $path === '') {
            return $fallback;
        }

        $path = trim($path);

        if ($path === '') {
            return $fallback;
        }

        // External URLs (http, https, data) - return as-is
        if (preg_match('/^(https?:|data:)/i', $path)) {
            return $path;
        }

        // Absolute path (starts with /) - return as-is
        if (str_starts_with($path, '/')) {
            return $path;
        }

        // Local storage path - check if file actually exists
        $storagePath = 'storage/' . ltrim($path, '/');
        $fullPath = public_path($storagePath);

        if (file_exists($fullPath)) {
            return asset($storagePath);
        }

        // File doesn't exist - return placeholder
        return $fallback;
    }
}

if (!function_exists('get_kos_primary_photo')) {
    /**
     * Get primary photo URL for a Kos model.
     *
     * @param \App\Models\Kos $kos
     * @param string|null $fallback
     * @return string
     */
    function get_kos_primary_photo($kos, ?string $fallback = null): string
    {
        $fallback = $fallback ?? asset('images/placeholder-kos.png');

        $primaryPhoto = $kos->photos
            ? $kos->photos->first()
            : null;

        return resolve_image_url($primaryPhoto?->url, $fallback);
    }
}