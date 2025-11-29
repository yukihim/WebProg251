<?php
// filepath: d:\Web\htdocs\quanswebsite\public\forgot_password.php
$pageTitle = "Forgot Password";
include '../app/Views/partials/header.php';

require_once '../app/Controllers/AuthController.php';

$authController = new AuthController();
$message = "";

function generateRandomPassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $password;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    if ($email) {
        $user = $authController->getUserByEmail($email);

        if ($user) {
            // Generate a new random password
            $newPassword = generateRandomPassword(8); // 8 random characters

            // Save the new hashed password to the database
            $authController->resetPassword($user['uid'], $newPassword);

            // Call js function
            echo "<script>
                const first_name = '" . addslashes($user['first_name']) . "';
                const last_name = '" . addslashes($user['last_name']) . "';
                const newPassword = '" . addslashes($newPassword) . "';
                const email = '" . addslashes($user['email']) . "';
                handleResetProcess(first_name, last_name, newPassword, email);
            </script>";

            $_SESSION['message'] = "An email have been sent with the new password to your email account. Please login below.";
        } else {
            $message = "No account found with that email address.";
        }
    } else {
        $message = "Please enter your email address.";
    }
}
?>

<div class="row g-0 justify-content-center mt-5 outer-form">
    <div class="col-md-7 d-flex align-items-stretch">
        <img src="/quanswebsite/public/uploads/forgot.jpg"
            alt="Forgot Password"
            class="img-fluid w-100 h-100 login-img">
    </div>
    <div class="col-md-5">
        <div class="card-auth">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">
                    <i class="fa-solid fa-key"></i> Forgot Password
                </h3>

                <?php if ($message): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Send Reset Password</button>
                </form>

                <p class="text-center mt-3 mb-0 small">
                    <a href="login.php" class="ref">Back to Login</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php //include '../app/Views/partials/footer.php'; ?>