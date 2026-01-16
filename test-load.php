<?php
require __DIR__.'/vendor/autoload.php';

// Test 1: Cek class langsung
echo "Test 1: class_exists('Barryvdh\\\\DomPDF\\\\ServiceProvider'): ";
echo class_exists('Barryvdh\DomPDF\ServiceProvider') ? '✅ OK' : '❌ FAIL';
echo "\n";

// Test 2: Manual include
echo "Test 2: Manual include...\n";
$file = __DIR__.'/vendor/barryvdh/laravel-dompdf/src/ServiceProvider.php';
if (file_exists($file)) {
    require_once $file;
    echo "File included successfully\n";
    
    echo "Test 3: After manual include: ";
    echo class_exists('Barryvdh\DomPDF\ServiceProvider') ? '✅ OK' : '❌ FAIL';
    echo "\n";
} else {
    echo "❌ File not found: $file\n";
}

// Test 4: Cek autoload
echo "\nTest 4: Checking autoload_psr4.php...\n";
$autoload = require __DIR__.'/vendor/composer/autoload_psr4.php';
foreach ($autoload as $ns => $paths) {
    if (strpos($ns, 'Barryvdh') !== false) {
        echo "Found: $ns => " . implode(', ', $paths) . "\n";
    }
}