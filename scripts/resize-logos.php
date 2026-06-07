<?php
/**
 * Resize logo.png into named variants for the site-logo component.
 *
 * Usage: php scripts/resize-logos.php
 */

function resizeAndCropLogo($sourcePath, $targetPath, $targetWidth, $targetHeight) {
    // Load source
    $src = imagecreatefrompng($sourcePath);
    if (!$src) {
        throw new RuntimeException("Cannot load image: $sourcePath");
    }

    $srcW = imagesx($src);
    $srcH = imagesy($src);

    // Preserve transparency
    imagealphablending($src, false);
    imagesavealpha($src, true);

    $target = imagecreatetruecolor($targetWidth, $targetHeight);
    imagealphablending($target, false);
    imagesavealpha($target, true);

    // Fill transparent background
    $transparent = imagecolorallocatealpha($target, 0, 0, 0, 127);
    imagefill($target, 0, 0, $transparent);

    // Calculate proportional scaling to fit within target dimensions (maintain aspect ratio like object-contain)
    $scaleX = $targetWidth / $srcW;
    $scaleY = $targetHeight / $srcH;
    $scale = min($scaleX, $scaleY); // object-contain

    $newW = (int) ($srcW * $scale);
    $newH = (int) ($srcH * $scale);

    // Center the resized image within the canvas
    $dstX = (int) (($targetWidth - $newW) / 2);
    $dstY = (int) (($targetHeight - $newH) / 2);

    imagecopyresampled($target, $src, $dstX, $dstY, 0, 0, $newW, $newH, $srcW, $srcH);

    imagepng($target, $targetPath, 9);
    imagedestroy($src);
    imagedestroy($target);
}

$baseDir = dirname(__DIR__) . '/public/images';
$source = $baseDir . '/logo.png';

$variants = [
    'logo-navbar.png'         => [ 'width' => 78,  'height' => 68 ],
    'logo-auth-navbar.png'   => [ 'width' => 88,  'height' => 76 ],
    'logo-footer.png'         => [ 'width' => 160, 'height' => 132 ],
    'logo-auth-footer.png'   => [ 'width' => 140, 'height' => 116 ],
    'logo-owner.png'         => [ 'width' => 126, 'height' => 104 ],
    'logo-hero.png'         => [ 'width' => 219, 'height' => 180 ],
];

foreach ($variants as $filename => $dims) {
    $target = $baseDir . '/' . $filename;
    try {
        resizeAndCropLogo($source, $target, $dims['width'], $dims['height']);
        echo "Generated: {$filename} ({$dims['width']}x{$dims['height']})\n";
    } catch (Throwable $e) {
        echo "FAILED {$filename}: " . $e->getMessage() . "\n";
        throw $e;
    }
}

echo "Done.\n";
