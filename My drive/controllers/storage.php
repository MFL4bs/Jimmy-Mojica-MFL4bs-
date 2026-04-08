<?php
session_start();
require_once '../models/User.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'storage') {
    $user = new User();
    $storageInfo = $user->getUserStorageInfo($_SESSION['user_id']);
    
    // Formatear los tamaños
    $used_formatted = formatBytes($storageInfo['used']);
    $limit_formatted = formatBytes($storageInfo['limit']);
    
    echo json_encode([
        'used' => $storageInfo['used'],
        'limit' => $storageInfo['limit'],
        'percentage' => round($storageInfo['percentage'], 1),
        'used_formatted' => $used_formatted,
        'limit_formatted' => $limit_formatted
    ]);
}

function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    
    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    
    return round($bytes, $precision) . ' ' . $units[$i];
}
?>