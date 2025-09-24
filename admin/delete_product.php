<?php
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    redirect('../index.php');
}

if (!isset($_GET['id'])) {
    redirect('index.php');
}

$product_id = intval($_GET['id']);
$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
$stmt->execute([$product_id]);

redirect('index.php');
?>