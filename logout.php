<?php
require_once 'includes/functions.php';

// Start session
session_start();

try {
    // Clear all session data
    $_SESSION = [];
    
    // Destroy the session
    if (session_destroy()) {
        // Redirect to home page
        redirect('index.php');
    } else {
        throw new Exception("Failed to destroy session.");
    }
} catch (Exception $e) {
    $error = "Logout failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Error - Sté CRZ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
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
            color: #1F2A44 !important;
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.5rem 1rem;
            transition: color 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            color: #3B82F6 !important;
        }
        .error-section {
            padding: 5rem 0;
            background-color: #FFFFFF;
        }
        .error-section h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: #3B82F6;
            letter-spacing: -0.025em;
            margin-bottom: 3rem;
            text-align: center;
        }
        .error-section .alert-danger {
            background-color: #EF4444;
            border-color: #EF4444;
            color: #FFFFFF;
        }
        .error-section .btn-primary {
            background-color: #3B82F6;
            border-color: #3B82F6;
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
        }
        .error-section .btn-primary:hover {
            background-color: #2563EB;
            border-color: #2563EB;
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
            .error-section h1 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="<?php echo SITE_URL; ?>index.php">
                <img src="assets/images/logo.png" alt="Sté CRZ Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>cart.php">Cart</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo SITE_URL; ?>register.php">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="error-section">
        <div class="container">
            <h1>Logout Error</h1>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <a href="index.php" class="btn btn-primary">Return to Home</a>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>