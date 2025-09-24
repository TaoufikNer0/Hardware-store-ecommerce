<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Sté CRZ</title>
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
        .confirmation-section {
            padding: 3rem 0;
            background-color: #FFFFFF;
        }
        .confirmation-section h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: #000000;
            letter-spacing: -0.025em;
            margin-bottom: 2rem;
            text-align: center;
        }
        .confirmation-section .btn-primary {
            background-color: #3B82F6;
            border-color: #3B82F6;
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
        }
        .confirmation-section .btn-primary:hover {
            background-color: #2563EB;
            border-color: #2563EB;
        }
        .card {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .card-content {
            padding: 1.5rem;
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
            .confirmation-section h2 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <section class="confirmation-section py-3 py-lg-5 py-xl-8">
        <div class="container">
            <h2>Order Confirmation</h2>
            <div class="card">
                <div class="card-content">
                    <p class="text-center">Thank you for your order! It has been successfully placed and is being processed.</p>
                    <p class="text-center">You'll receive a confirmation email soon.</p>
                    <div class="text-center">
                        <a href="products.php" class="btn btn-primary">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include 'includes/footer.php'; ?>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>