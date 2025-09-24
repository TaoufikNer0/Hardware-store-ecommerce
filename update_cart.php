<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

if (!isset($_GET['id'])) {
    redirect('products.php');
}
$product_id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    redirect('products.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = intval($_POST['quantity']);
    if ($quantity > 0 && $quantity <= $product['stock']) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][$product_id] = $quantity;
        redirect('cart.php');
    } else {
        $error = "Invalid quantity or out of stock.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Sté CRZ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <style>
        .product-detail-section {
            padding: 5rem 0;
            background-color: #FFFFFF;
        }
        .product-detail-section h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: #3B82F6;
            margin-bottom: 1.5rem;
        }
        .product-detail-section p {
            font-family: 'Roboto', sans-serif;
            font-size: 1.25rem;
            color: #6B7280;
        }
        .product-detail-section img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <section class="product-detail-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <img src="assets/images/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                <div class="col-lg-6">
                    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category_name']); ?></p>
                    <p><strong>Price:</strong> <?php echo number_format($product['price'], 2); ?> MAD</p>
                    <p><strong>Stock:</strong> <?php echo $product['stock']; ?> available</p>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="<?php echo $product['stock']; ?>" value="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>