<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';
require_once 'vendor/autoload.php';

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

if (!isset($_GET['session_id'])) {
    redirect('cart.php');
}

$session = \Stripe\Checkout\Session::retrieve($_GET['session_id']);
if ($session->payment_status === 'paid') {
    unset($_SESSION['cart']); // Clear cart after successful payment
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container my-5">
        <h1 class="text-center mb-4">Payment Successful</h1>
        <p class="text-center">Thank you for your purchase! Your order has been placed.</p>
        <a href="index.php" class="btn btn-primary">Return to Home</a>
    </div>
    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>