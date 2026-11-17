<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

define('LARAVEL_START', microtime(true));

// Setup writable storage directory in temporary directory
$tempDir = rtrim(sys_get_temp_dir(), '/\\');
$storagePath = $tempDir.'/storage';

$storageDirs = [
    $storagePath.'/app/public',
    $storagePath.'/framework/cache/data',
    $storagePath.'/framework/sessions',
    $storagePath.'/framework/views',
    $storagePath.'/logs',
];

foreach ($storageDirs as $dir) {
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Point compiled views to writable temp directory
putenv("VIEW_COMPILED_PATH={$storagePath}/framework/views");
$_ENV['VIEW_COMPILED_PATH'] = "{$storagePath}/framework/views";
$_SERVER['VIEW_COMPILED_PATH'] = "{$storagePath}/framework/views";

// SQLite database handling
$dbConnection = getenv('DB_CONNECTION') ?: ($_ENV['DB_CONNECTION'] ?? 'sqlite');
$needsMigration = false;

if ($dbConnection === 'sqlite') {
    $dbPath = $tempDir.'/database.sqlite';
    $sourceDb = __DIR__.'/../database/database.sqlite';

    if (! file_exists($dbPath)) {
        if (file_exists($sourceDb) && filesize($sourceDb) > 0) {
            copy($sourceDb, $dbPath);
        } else {
            touch($dbPath);
            $needsMigration = true;
        }
    }

    putenv("DB_DATABASE={$dbPath}");
    $_ENV['DB_DATABASE'] = $dbPath;
    $_SERVER['DB_DATABASE'] = $dbPath;
}

// Register Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Tell Laravel to use our temporary storage path
$app->useStoragePath($storagePath);

// Run migrations on first cold boot if database was newly created
if ($needsMigration) {
    try {
        Artisan::call('migrate', ['--force' => true]);
    } catch (Throwable $e) {
        error_log('Automatic migration failed: '.$e->getMessage());
    }
}

// Handle request
$app->handleRequest(Request::capture());
