@props([
    'href' => null,
    'alt' => 'KosCheck',
    'variant' => 'navbar',
])

@php
    // Map variants to specific pre-sized logo files
    $logoFile = match ($variant) {
        'auth-navbar' => 'logo-auth-navbar.png',
        'footer' => 'logo-footer.png',
        'auth-footer' => 'logo-auth-footer.png',
        'owner' => 'logo-owner.png',
        'hero' => 'logo-hero.png',
        default => 'logo-navbar.png',
    };

    $logoPath = public_path("images/{$logoFile}");
    $logoVersion = file_exists($logoPath) ? filemtime($logoPath) : time();
    $logoUrl = asset("images/{$logoFile}") . '?v=' . $logoVersion;

    $dimensions = match ($variant) {
        'auth-navbar' => ['width' => 88, 'height' => 76],
        'footer' => ['width' => 160, 'height' => 132],
        'auth-footer' => ['width' => 140, 'height' => 116],
        'owner' => ['width' => 110, 'height' => 34],
        'hero' => ['width' => 219, 'height' => 180],
        default => ['width' => 110, 'height' => 110],
    };
@endphp

@php
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
