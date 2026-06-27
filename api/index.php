<?php

// Set production environment variables
$_ENV['APP_ENV'] = 'production';
$_ENV['APP_DEBUG'] = 'true'; // Keep true for now to see issues if any
$_ENV['APP_KEY'] = 'base64:f6AMDYsHMqvy15e4ISdehxoP0RoVx7T17NSD34UlhWM=';

// Log to stderr on Vercel so logs are visible in Vercel Console
$_ENV['LOG_CHANNEL'] = 'stderr';

// Set storage path to /tmp which is writable on Vercel
$_ENV['APP_STORAGE'] = '/tmp';

// Ensure storage subdirectories exist in /tmp
$dirs = [
    '/tmp/framework/views',
    '/tmp/framework/cache',
    '/tmp/framework/sessions',
    '/tmp/logs'
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Auto-detect and bridge Vercel Postgres variables to Laravel DB connection
if (isset($_ENV['POSTGRES_HOST'])) {
    $_ENV['DB_CONNECTION'] = 'pgsql';
    $_ENV['DB_HOST'] = $_ENV['POSTGRES_HOST'];
    $_ENV['DB_PORT'] = $_ENV['POSTGRES_PORT'] ?? '5432';
    $_ENV['DB_DATABASE'] = $_ENV['POSTGRES_DATABASE'];
    $_ENV['DB_USERNAME'] = $_ENV['POSTGRES_USER'];
    $_ENV['DB_PASSWORD'] = $_ENV['POSTGRES_PASSWORD'];
} elseif (isset($_ENV['DB_HOST'])) {
    // If user inputs manual DB credentials, let Laravel use them
    $_ENV['DB_CONNECTION'] = $_ENV['DB_CONNECTION'] ?? 'mysql';
}

// Arahkan request Vercel ke index.php public Laravel
require __DIR__ . '/../public/index.php';

