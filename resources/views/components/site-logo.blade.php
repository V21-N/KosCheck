@props([
    'href' => null,
    'alt' => 'KosCheck',
    'variant' => 'navbar',
])

@php
    // All variants now use the central logo.png
    // Dimensions are maintained for consistent visual sizing across variants
    $dimensions = match ($variant) {
        'auth-navbar' => ['width' => 88, 'height' => 76],
        'footer' => ['width' => 160, 'height' => 132],
        'auth-footer' => ['width' => 140, 'height' => 116],
        'owner' => ['width' => 110, 'height' => 34],
        'hero' => ['width' => 219, 'height' => 180],
        default => ['width' => 110, 'height' => 110],
    };

    $logoPath = public_path('images/logo.png');
    $logoVersion = file_exists($logoPath) ? filemtime($logoPath) : time();
    $logoUrl = asset('images/logo.png') . '?v=' . $logoVersion;

    $style = "width:{$dimensions['width']}px;height:{$dimensions['height']}px";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex shrink-0', 'style' => $style]) }}>
        <img
            src="{{ $logoUrl }}"
            alt="{{ $alt }}"
            class="h-full w-full object-contain"
            decoding="async"
            loading="eager"
        >
    </a>
@else
    <div {{ $attributes->merge(['class' => 'inline-flex shrink-0', 'style' => $style]) }}>
        <img
            src="{{ $logoUrl }}"
            alt="{{ $alt }}"
            class="h-full w-full object-contain"
            decoding="async"
            loading="eager"
        >
    </div>
@endif
