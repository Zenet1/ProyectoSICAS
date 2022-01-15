<?php
require_once "vendor/autoload.php";
$dotenv;

try {
    $dotenv = Dotenv\Dotenv::createImmutable(DIR);
    $dotenv->safeLoad();
} catch (Exception $e) {
    echo "Error en utileria";
}