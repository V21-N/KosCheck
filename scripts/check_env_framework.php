<?php
require __DIR__ . '/../vendor/autoload.php';
use Illuminate\Support\Env;
use Dotenv\Dotenv;

// Use same repository as framework
$dotenv = Dotenv::create(Env::getRepository(), __DIR__ . '/..', '.env');
$dotenv->safeLoad();
var_dump(Env::get('APP_KEY'));
var_dump($_ENV['APP_KEY'] ?? null);
var_dump($_SERVER['APP_KEY'] ?? null);
?>