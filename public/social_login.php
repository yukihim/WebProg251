<?php

// 1. Start Session immediately (Required for HybridAuth)
if (session_status() === PHP_SESSION_NONE) session_start();

// 2. DO NOT include header.php here. 
require_once '../vendor/hybridauth-3.12.2/src/autoload.php';
$config = require '../config/hybridauth_config.php';

use Hybridauth\Hybridauth;

$providerName = $_GET['provider'] ?? null;

// Validate provider name
if (!$providerName || !isset($config['providers'][$providerName]) || !$config['providers'][$providerName]['enabled']) {
    $_SESSION['message'] = 'Invalid or disabled provider.';
    header('Location: login.php');
    exit;
}

try {
    $hybridauth = new Hybridauth($config);

    // Authenticate and redirect to provider
    $adapter = $hybridauth->authenticate($providerName);

    // No further code needed; HybridAuth handles redirect.
    exit;

} catch (\Exception $e) {
    $_SESSION['message'] = "Authentication failed: " . htmlspecialchars($e->getMessage());
    header('Location: login.php');
    exit;
}