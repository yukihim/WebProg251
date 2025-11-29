<?php
if (!isset($pageTitle)) $pageTitle = "Homepage - The Executive Garage";
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Browse, search, and discover luxury and performance cars at The Executive Garage. Find your dream car from top brands with detailed information and images.">

    <title><?= htmlspecialchars($pageTitle) ?></title>


    <!-- Other CSS and JS links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/quanswebsite/public/CSS/style.css" rel="stylesheet">

    <!-- EmailJS Tutorial: https://www.youtube.com/watch?v=BgVjild0C9A -->
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js">
    </script>
    <script type="text/javascript">
        (function(){
            emailjs.init({
                publicKey: "Gk5db20IwPdzTF_mh",
            });
        })();
    </script>

    <!-- Custom JS for reset password functionality -->
    <script src="/quanswebsite/public/js/resetPassword.js"></script>

    <!-- Custom JS for ajax search functionality -->
    <script src="/quanswebsite/public/js/ajaxSearch.js"></script>

    <!-- For Google Login -->
    <!-- <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <meta name="google-signin-client_id" content="323464211046-oeu4dv0ibqnj9ifddgl23gs6g70m00mv.apps.googleusercontent.com">
    <script src="https://accounts.google.com/gsi/client" async defer></script> -->

    <!-- For Facebook Login -->
    <!-- <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script> -->

    <!-- Custom JS for effects functionality -->
    <script src="/quanswebsite/public/js/otherEffects.js"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg fixed-top bg-black shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/quanswebsite/public/index.php">
            <!-- <i class="fa-solid fa-car"></i> -->
            The Executive Garage
        </a>


        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <!-- <span class="navbar-toggler-icon"></span> -->
            <span class="fa fa-bars fa-2x" style="color: #FFDF00;"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav mb-2 mb-lg-0 gap-3">
                <li class="nav-item">
                    <a class="nav-link <?= ($pageTitle=='Homepage - The Executive Garage'?'active':'') ?>" href="/quanswebsite/public/index.php">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($pageTitle=='Contact'?'active':'') ?>" href="/quanswebsite/public/contact.php">
                        Contact
                    </a>
                </li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-danger" href="/quanswebsite/public/logout.php">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary" href="/quanswebsite/public/login.php">
                            <i class="fa-solid fa-user"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="/quanswebsite/public/signup.php">
                            <i class="fa-solid fa-user-plus"></i> Sign Up
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container">
