<?php
/**
 * MindFit Server Diagnostics
 * Akses via: https://app.mindfit.id/server-check
 * HAPUS FILE INI SETELAH SELESAI DEBUGGING!
 */

header('Content-Type: application/json');

$diagnostics = [];

// 1. PHP Version
$diagnostics['php_version'] = phpversion();

// 2. PHP Extensions yang dibutuhkan
$requiredExtensions = ['zip', 'gd', 'xml', 'mbstring', 'fileinfo', 'openssl', 'pdo', 'pdo_mysql', 'curl', 'json', 'dom'];
$diagnostics['extensions'] = [];
foreach ($requiredExtensions as $ext) {
    $diagnostics['extensions'][$ext] = extension_loaded($ext) ? 'OK' : 'MISSING';
}

// Determine actual mindfit_app base directory
$baseAppDir = is_dir('/home/omag8228/mindfit_app') ? '/home/omag8228/mindfit_app' : realpath(__DIR__ . '/..');

// 3. Path info
$diagnostics['paths'] = [
    'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'N/A',
    'script_filename' => $_SERVER['SCRIPT_FILENAME'] ?? 'N/A',
    'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
    'cwd' => getcwd(),
    'base_path' => $baseAppDir,
    'storage_path' => $baseAppDir . '/storage',
    'public_storage_link_exists' => is_link(__DIR__ . '/storage') ? 'YES (symlink)' : (is_dir(__DIR__ . '/storage') ? 'YES (real dir)' : 'NO'),
    'public_storage_link_target' => is_link(__DIR__ . '/storage') ? readlink(__DIR__ . '/storage') : 'NOT A SYMLINK',
];

// 4. Storage images check
$diagnostics['storage_files'] = [];
$logoPath1 = __DIR__ . '/storage/images/logo.png';
$logoPath2 = $baseAppDir . '/storage/app/public/images/logo.png';
$diagnostics['storage_files']['public/storage/images/logo.png'] = file_exists($logoPath1) ? 'EXISTS (' . filesize($logoPath1) . ' bytes)' : 'NOT FOUND';
$diagnostics['storage_files']['storage/app/public/images/logo.png'] = file_exists($logoPath2) ? 'EXISTS (' . filesize($logoPath2) . ' bytes)' : 'NOT FOUND';

// 5. Check if avatars directory exists
$avatarsPath1 = __DIR__ . '/storage/avatars';
$avatarsPath2 = $baseAppDir . '/storage/app/public/avatars';
$diagnostics['storage_files']['public/storage/avatars/'] = is_dir($avatarsPath1) ? 'DIR EXISTS' : 'NOT FOUND';
$diagnostics['storage_files']['storage/app/public/avatars/'] = is_dir($avatarsPath2) ? 'DIR EXISTS' : 'NOT FOUND';

// 6. Git info
$diagnostics['git'] = [];
$gitHead = @file_get_contents($baseAppDir . '/.git/HEAD');
$diagnostics['git']['HEAD'] = $gitHead ? trim($gitHead) : 'NOT FOUND';
if ($gitHead && strpos($gitHead, 'ref:') === 0) {
    $refPath = $baseAppDir . '/.git/' . trim(substr($gitHead, 5));
    $diagnostics['git']['commit'] = @file_get_contents($refPath) ? trim(file_get_contents($refPath)) : 'CANNOT READ';
}

// 7. Laravel cache check
$diagnostics['laravel_cache'] = [];
$configCachePath = $baseAppDir . '/bootstrap/cache/config.php';
$routesCachePath = $baseAppDir . '/bootstrap/cache/routes-v7.php';
$diagnostics['laravel_cache']['config_cached'] = file_exists($configCachePath) ? 'YES (modified: ' . date('Y-m-d H:i:s', filemtime($configCachePath)) . ')' : 'NO';
$diagnostics['laravel_cache']['routes_cached'] = file_exists($routesCachePath) ? 'YES (modified: ' . date('Y-m-d H:i:s', filemtime($routesCachePath)) . ')' : 'NO';

// 8. Composer vendor check
$diagnostics['vendor'] = [];
$diagnostics['vendor']['vendor_dir_exists'] = is_dir($baseAppDir . '/vendor') ? 'YES' : 'NO';
$diagnostics['vendor']['dompdf_installed'] = is_dir($baseAppDir . '/vendor/barryvdh/laravel-dompdf') ? 'YES' : 'NO';
$diagnostics['vendor']['phpspreadsheet_installed'] = is_dir($baseAppDir . '/vendor/phpoffice/phpspreadsheet') ? 'YES' : 'NO';

// 9. Recent laravel.log errors
$logFile = $baseAppDir . '/storage/logs/laravel.log';
if (file_exists($logFile)) {
    $logContent = file($logFile);
    $lastLines = array_slice($logContent, -60);
    $diagnostics['recent_log_tail'] = array_values(array_filter(array_map('trim', $lastLines)));
} else {
    $diagnostics['recent_log_tail'] = 'LOG FILE NOT FOUND at ' . $logFile;
}

// 10. PHP upload limits
$diagnostics['php_limits'] = [
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'memory_limit' => ini_get('memory_limit'),
    'max_execution_time' => ini_get('max_execution_time'),
];

// 11. Server time
$diagnostics['server_time'] = date('Y-m-d H:i:s T');

echo json_encode($diagnostics, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
