<?php

// 1. Arahkan ke autoload milik composer
require __DIR__ . '/vendor/autoload.php';

// 2. Arahkan ke bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);