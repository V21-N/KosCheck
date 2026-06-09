<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$loaded = $dotenv->load();
var_dump(array_key_exists('APP_KEY', $loaded));
var_dump($loaded['APP_KEY'] ?? null);
var_dump(getenv('APP_KEY'));
var_dump($_ENV['APP_KEY'] ?? null);
var_dump($_SERVER['APP_KEY'] ?? null);
