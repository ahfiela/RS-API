<?php

// Paksa Laravel menggunakan folder /tmp untuk menyimpan views terkompilasi
# Untuk memastikan sistem tidak crash karena read-only filesystem
$viewPath = '/tmp/storage/framework/views';
if (!is_dir($viewPath)) {
    mkdir($viewPath, 0755, true);
}
putenv("VIEW_COMPILED_PATH={$viewPath}");

// Jalankan index utama Laravel
require __DIR__ . '/../public/index.php';
