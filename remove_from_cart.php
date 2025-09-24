<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }
}
redirect('cart.php');
?>