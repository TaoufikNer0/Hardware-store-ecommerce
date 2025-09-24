<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

if (!isset($_GET['id'])) {
    redirect('produits.php');
}
$product_id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    redirect('produits.php');
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = intval($_POST['quantity']);
    if ($quantity <= 0 || $quantity > $product['stock']) {
        $errors[] = "Veuillez sélectionner une quantité valide (1–{$product['stock']}).";
    } else {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + $quantity;
        redirect('cart.php');
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Sté CRZ</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; color: #1F2A44; background-color: #F9FAFB; }
        .navbar { background-color: #FFFFFF; position: sticky; top: 0; z-index: 1030; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .navbar-brand img { height: 40px; }
        .nav-link { color: #000000 !important; font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 1.1rem; padding: 0.5rem 1rem; transition: color 0.3s; }
        .nav-link:hover, .nav-link.active { color: #3B82F6 !important; }
        .product-detail-section { padding: 3rem 0; background-color: #FFFFFF; }
        .product-detail-section h2 { font-family: 'Montserrat', sans-serif; font-size: 2.5rem; font-weight: 700; color: #000000; margin-bottom: 1rem; }
        .product-detail-section img { max-width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; }
        .product-detail-section .price { font-family: 'Montserrat', sans-serif; font-size: 1.8rem; font-weight: 700; color: #000000; }
        .product-detail-section .btn-primary { background-color: #3B82F6; border-color: #3B82F6; font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 1.1rem; padding: 0.75rem 1.5rem; border-radius: 8px; }
        .product-detail-section .btn-primary:hover { background-color: #2563EB; border-color: #2563EB; }
        footer { background-color: #1F2A44; color: #FFFFFF; padding: 2rem 0; text-align: center; font-family: 'Roboto', sans-serif; font-size: 1rem; }
        footer a { color: #3B82F6; text-decoration: none; margin: 0 0.5rem; }
        footer a:hover { color: #2563EB; }
        @media (max-width: 768px) { .product-detail-section h2 { font-size: 2rem; } .product-detail-section .price { font-size: 1.5rem; } .product-detail-section img { max-height: 300px; } }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <section class="product-detail-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                <div class="col-md-6">
                    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p class="text-muted"><?php echo htmlspecialchars($product['category_name']); ?></p>
                    <p class="price"><?php echo number_format($product['price'], 2); ?> MAD</p>
                    <p><strong>Stock :</strong> <?php echo $product['stock'] > 0 ? $product['stock'] . ' disponible' : 'Rupture de stock'; ?></p>
                    <p><strong>Frais de livraison :</strong> <?php echo number_format($product['shipping_fee'], 2); ?> MAD</p>
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $error): ?>
                                <p><?php echo htmlspecialchars($error); ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($product['stock'] > 0): ?>
                        <form method="POST" class="mb-3">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantité</label>
                                <input type="number" class="form-control w-25" id="quantity" name="quantity" min="1" max="<?php echo $product['stock']; ?>" value="1" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                        </form>
                    <?php else: ?>
                        <p class="text-danger">Ce produit est actuellement en rupture de stock.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php include 'includes/footer.php'; ?>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>