<?php

// Set production environment variables
putenv('APP_ENV=production');
$_ENV['APP_ENV'] = 'production';
$_SERVER['APP_ENV'] = 'production';

putenv('APP_DEBUG=true');
$_ENV['APP_DEBUG'] = 'true';
$_SERVER['APP_DEBUG'] = 'true';

putenv('APP_KEY=base64:f6AMDYsHMqvy15e4ISdehxoP0RoVx7T17NSD34UlhWM=');
$_ENV['APP_KEY'] = 'base64:f6AMDYsHMqvy15e4ISdehxoP0RoVx7T17NSD34UlhWM=';
$_SERVER['APP_KEY'] = 'base64:f6AMDYsHMqvy15e4ISdehxoP0RoVx7T17NSD34UlhWM=';

// Log to stderr on Vercel so logs are visible in Vercel Console
putenv('LOG_CHANNEL=stderr');
$_ENV['LOG_CHANNEL'] = 'stderr';
$_SERVER['LOG_CHANNEL'] = 'stderr';

// Set storage path to /tmp which is writable on Vercel
putenv('APP_STORAGE=/tmp');
$_ENV['APP_STORAGE'] = '/tmp';
$_SERVER['APP_STORAGE'] = '/tmp';

// Bypass bootstrap cache files by redirecting them to /tmp
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
$_SERVER['APP_PACKAGES_CACHE'] = '/tmp/packages.php';

putenv('APP_SERVICES_CACHE=/tmp/services.php');
$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
$_SERVER['APP_SERVICES_CACHE'] = '/tmp/services.php';

// Ensure storage subdirectories exist in /tmp
$dirs = [
    '/tmp/framework/views',
    '/tmp/framework/cache',
    '/tmp/framework/sessions',
    '/tmp/logs'
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Auto-detect and bridge Vercel Postgres variables to Laravel DB connection
$postgresHost = $_ENV['POSTGRES_HOST'] ?? $_SERVER['POSTGRES_HOST'] ?? getenv('POSTGRES_HOST');
if ($postgresHost) {
    $dbPort = $_ENV['POSTGRES_PORT'] ?? $_SERVER['POSTGRES_PORT'] ?? getenv('POSTGRES_PORT') ?? '5432';
    $dbName = $_ENV['POSTGRES_DATABASE'] ?? $_SERVER['POSTGRES_DATABASE'] ?? getenv('POSTGRES_DATABASE');
    $dbUser = $_ENV['POSTGRES_USER'] ?? $_SERVER['POSTGRES_USER'] ?? getenv('POSTGRES_USER');
    $dbPassword = $_ENV['POSTGRES_PASSWORD'] ?? $_SERVER['POSTGRES_PASSWORD'] ?? getenv('POSTGRES_PASSWORD');

    putenv("DB_CONNECTION=pgsql");
    $_ENV['DB_CONNECTION'] = 'pgsql';
    $_SERVER['DB_CONNECTION'] = 'pgsql';

    putenv("DB_HOST=$postgresHost");
    $_ENV['DB_HOST'] = $postgresHost;
    $_SERVER['DB_HOST'] = $postgresHost;

    putenv("DB_PORT=$dbPort");
    $_ENV['DB_PORT'] = $dbPort;
    $_SERVER['DB_PORT'] = $dbPort;

    putenv("DB_DATABASE=$dbName");
    $_ENV['DB_DATABASE'] = $dbName;
    $_SERVER['DB_DATABASE'] = $dbName;

    putenv("DB_USERNAME=$dbUser");
    $_ENV['DB_USERNAME'] = $dbUser;
    $_SERVER['DB_USERNAME'] = $dbUser;

    putenv("DB_PASSWORD=$dbPassword");
    $_ENV['DB_PASSWORD'] = $dbPassword;
    $_SERVER['DB_PASSWORD'] = $dbPassword;
} elseif (isset($_ENV['DB_HOST']) || isset($_SERVER['DB_HOST'])) {
    // If user inputs manual DB credentials, let Laravel use them
    $connection = $_ENV['DB_CONNECTION'] ?? $_SERVER['DB_CONNECTION'] ?? 'mysql';
    putenv("DB_CONNECTION=$connection");
    $_ENV['DB_CONNECTION'] = $connection;
    $_SERVER['DB_CONNECTION'] = $connection;
}

// Arahkan request Vercel ke index.php public Laravel
require __DIR__ . '/../public/index.php';

