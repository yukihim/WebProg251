<?php
// 1. Start Session (Must be first line)
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_GET['error'])) {
    $_SESSION['message'] = "Social login cancelled or failed.";
    header("Location: /quanswebsite/public/index.php");
    exit;
}

require_once '../vendor/hybridauth-3.12.2/src/autoload.php';
$config = require '../config/hybridauth_config.php';

use Hybridauth\Hybridauth;

try {
    $hybridauth = new Hybridauth($config);

    // Try to get connected adapters
    $adapters = $hybridauth->getConnectedAdapters();

    // If no adapters, try to authenticate each enabled provider
    if (empty($adapters)) {
        foreach ($config['providers'] as $name => $params) {
            if ($params['enabled']) {
                try {
                    $hybridauth->authenticate($name);
                } catch (\Exception $e) {
                    // Ignore failed attempt, redirect to homepage
                    // header("Location: /quanswebsite/public/index.php");
                    // exit;
                    continue;
                }
            }
        }
        $adapters = $hybridauth->getConnectedAdapters();
    }

    if (empty($adapters)) {
        throw new Exception("No provider connected. Session may have been lost or State mismatch.");
    }

    // Use the first connected adapter
    $adapter = reset($adapters);
    $userProfile = $adapter->getUserProfile();

    // --- Database Logic ---
    require_once '../app/Controllers/AuthController.php';
    $authController = new AuthController();
    $user = $authController->getUserByEmail($userProfile->email);

    if (!$user) {
        // Registration logic
        $firstName = !empty($userProfile->firstName) ? $userProfile->firstName : " ";
        $lastName = !empty($userProfile->lastName) ? $userProfile->lastName : " ";
        $data = [
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'email'      => $userProfile->email,
            'password'   => bin2hex(random_bytes(8)), // Random password
            'created_at' => date('Y-m-d H:i:s')
        ];
        $authController->register($data);
        $user = $authController->getUserByEmail($userProfile->email);
    }

    // Login the user
    $_SESSION['user'] = $user;
    $_SESSION['message'] = "Welcome back, " . htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']) . "!";

    // Redirect to Home
    header("Location: /quanswebsite/public/index.php");
    exit;

} catch (\Exception $e) {
    require_once '../app/Views/partials/header.php'; 
    echo "<div class='alert alert-danger'>Authentication Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    // Debugging (Only enable if needed)
    // echo "<pre>"; print_r($_SESSION); echo "</pre>";
}