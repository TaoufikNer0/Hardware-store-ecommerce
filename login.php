<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {  // FIXED: Use password_verify
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        redirect('index.php');
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sté CRZ</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/heroes/hero-3/assets/css/hero-3.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #1F2A44;
            background-color: #F9FAFB;
        }
        .navbar {
            background-color: #FFFFFF;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand img {
            height: 40px;
            width: auto;
        }
        .nav-link {
            color: #000000 !important;
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.5rem 1rem;
            transition: color 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: #3B82F6 !important;
        }
        .login-section {
            padding: 3rem 0;
            background-color: #FFFFFF;
        }
        .login-section h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: #000000;
            letter-spacing: -0.025em;
            margin-bottom: 2rem;
            text-align: center;
        }
        .login-section .btn-primary {
            background-color: #3B82F6;
            border-color: #3B82F6;
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
        }
        .login-section .btn-primary:hover {
            background-color: #2563EB;
            border-color: #2563EB;
        }
        .login-section .btn-link {
            color: #3B82F6;
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
        }
        .login-section .btn-link:hover {
            color: #2563EB;
        }
        footer {
            background-color: #1F2A44;
            color: #FFFFFF;
            padding: 2rem 0;
            text-align: center;
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
        }
        footer a {
            color: #3B82F6;
            text-decoration: none;
            margin: 0 0.5rem;
        }
        footer a:hover {
            color: #2563EB;
        }
        @media (max-width: 768px) {
            .login-section h2 {
                font-size: 2.5rem;
            }
            .login-section .form-label {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <section class="login-section py-3 py-lg-5 py-xl-8">
        <div class="container">
            <h2>Login</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" class="mx-auto" style="max-width: 500px;">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <a href="register.php" class="btn btn-link d-block text-center mt-2">Don't have an account? Register</a>
            </form>
        </div>
    </section>
    <?php include 'includes/footer.php'; ?>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>