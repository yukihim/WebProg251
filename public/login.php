<?php
$pageTitle = "Login";
include '../app/Views/partials/header.php';
require_once '../app/Controllers/AuthController.php';

$authController = new AuthController();
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $authController->login($email, $password);
    if ($user) {
        $_SESSION['user'] = $user;
        $_SESSION['message'] = "Welcome back, " . htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']) . "!";
        header("Location: index.php");
        exit;
    } else {
        $message = "Invalid email or password.";
    }
}
?>

<div class="row g-0 justify-content-end mt-5 outer-form">
    <div class="col-md-7 d-flex align-items-stretch">
        <img src="/quanswebsite/public/uploads/login2.jpg"
            alt="Login"
            class="img-fluid w-100 h-100 login-img">
    </div>
    <div class="col-md-5">
        <div class="card-auth">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">
                    <i class="fa-solid fa-user"></i> Login
                </h3>

                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-success">
                        <?= htmlspecialchars($_SESSION['message']) ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <?php if ($message): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <div class="mt-2 mb-3 text-center">
                    <div class="row g-2">
                        <div class="col-6 justify-content-center align-items-center">
                            <a href="social_login.php?provider=Google"
                                id="google-login-btn"
                                class="btn btn-outline-danger w-100">
                                <i class="fab fa-google social-login-icon"></i>
                                <span class="social-login-text">Log in with Google</span>
                            </a>
                            <!-- <div class="g-signin2"data-onsuccess="onSignIn""></div> -->
                        </div>
                        <div class="col-6">
                            <a href="social_login.php?provider=Facebook"
                                id="facebook-login-btn"
                                class="btn btn-outline-primary w-100"
                                onclick="loginWithFacebook();">
                                <i class="fab fa-facebook-f social-login-icon"></i>
                                <span class="social-login-text">Log in with Facebook</span>
                            </a>
                        </div>
                    </div>
                </div>

                <p class="text-center mt-4 mb-2 small">
                    Forgot password? <a href="forgot_password.php" class="ref">Reset here</a>.
                </p>
                <p class="text-center small">
                    Don't have an account? <a href="signup.php" class="ref">Sign up here</a>.
                </p>
            </div>
        </div>
    </div>
</div>

<?php //include '../app/Views/partials/footer.php'; ?>
