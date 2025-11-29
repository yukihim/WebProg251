<?php
$pageTitle = "Sign Up";
include '../app/Views/partials/header.php';
require_once '../app/Controllers/AuthController.php';

$authController = new AuthController();
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'created_at' => date('Y-m-d H:i:s')
    ];

    if ($authController->register($data)) {
        $_SESSION['message'] = "Registration successful! You can now log in.";
        header("Location: login.php");
        exit();
    } else {
        $message = "Error during registration. Try again.";
    }
}
?>

<div class="row g-0 justify-content-center mt-5 outer-form">
    <div class="col-md-7 d-flex align-items-stretch">
        <img src="/quanswebsite/public/uploads/login.jpg"
            alt="Sign Up"
            class="img-fluid w-100 h-100 login-img">
    </div>
    <div class="col-md-5">
        <div class="card-auth">
            <div class="card-body p-4">
                <h3 class="text-center mb-4"><i class="fa-solid fa-user-plus"></i> Create an Account</h3>

                <?php if ($message): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">First Name</label>
                        <input type="text" id="name" name="first_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Last Name</label>
                        <input type="text" id="name" name="last_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                </form>

                <p class="text-center mt-3 small">
                    Already have an account? <a href="login.php" class="ref">Login here</a>.
                </p>
            </div>
        </div>
    </div>
</div>

<?php //include '../app/Views/partials/footer.php'; ?>
