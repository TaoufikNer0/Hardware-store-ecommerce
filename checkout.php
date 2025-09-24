<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

$errors = [];
$success = '';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $errors[] = "Votre panier est vide. Ajoutez des articles avant de passer commande.";
} else {
    $user_id = isLoggedIn() ? $_SESSION['user_id'] : NULL;
    $subtotal = 0;
    $delivery_fee = 0;
    $cart_items = [];

    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT id, price, shipping_fee, stock FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($products)) {
        $errors[] = "Articles du panier invalides. Veuillez actualiser et réessayer.";
    } else {
        foreach ($products as $product) {
            $quantity = $_SESSION['cart'][$product['id']];
            if ($quantity > $product['stock']) {
                $errors[] = "Stock insuffisant pour le produit ID {$product['id']}. Veuillez mettre à jour votre panier.";
                break;
            }
            $item_subtotal = $product['price'] * $quantity;
            $item_shipping = ($product['shipping_fee'] ?? 0) * $quantity;
            $subtotal += $item_subtotal;
            $delivery_fee += $item_shipping;
            $cart_items[$product['id']] = [
                'price' => $product['price'],
                'shipping_fee' => $product['shipping_fee'] ?? 0,
                'quantity' => $quantity
            ];
        }

        if (empty($errors) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $customer_name = sanitize($_POST['customer_name']);
            $address = sanitize($_POST['address']);
            $city = sanitize($_POST['city']);
            $phone = sanitize($_POST['phone']);

            if (empty($customer_name) || empty($address) || empty($city) || empty($phone)) {
                $errors[] = "Tous les détails de livraison sont requis.";
            } else {
                try {
                    $pdo->beginTransaction();
                    $stmt = $pdo->prepare("INSERT INTO orders (user_id, customer_name, address, city, phone, delivery_fee, total_amount, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
                    $stmt->execute([$user_id, $customer_name, $address, $city, $phone, $delivery_fee, $subtotal + $delivery_fee]);
                    $order_id = $pdo->lastInsertId();

                    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, shipping_fee) VALUES (?, ?, ?, ?, ?)");
                    foreach ($cart_items as $product_id => $item) {
                        $stmt->execute([$order_id, $product_id, $item['quantity'], $item['price'], $item['shipping_fee']]);
                        $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?")->execute([$item['quantity'], $product_id]);
                    }

                    unset($_SESSION['cart']);
                    $pdo->commit();
                    $success = "Commande #$order_id passée avec succès ! Paiement à la livraison.";
                } catch (Exception $e) {
                    $pdo->rollBack();
                    $errors[] = "Échec de la commande : " . htmlspecialchars($e->getMessage());
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande - Sté CRZ</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; color: #1F2A44; background-color: #F9FAFB; }
        .navbar { background-color: #FFFFFF; position: sticky; top: 0; z-index: 1030; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .navbar-brand img { height: 40px; }
        .nav-link { color: #000000 !important; font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 1.1rem; padding: 0.5rem 1rem; transition: color 0.3s; }
        .nav-link:hover, .nav-link.active { color: #3B82F6 !important; }
        .checkout-section { padding: 3rem 0; background-color: #FFFFFF; }
        .checkout-section h2 { font-family: 'Montserrat', sans-serif; font-size: 2.5rem; font-weight: 700; color: #000000; margin-bottom: 2rem; text-align: center; }
        .checkout-section .btn-primary { background-color: #3B82F6; border-color: #3B82F6; font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 1.1rem; padding: 0.75rem 1.5rem; border-radius: 8px; }
        .checkout-section .btn-primary:hover { background-color: #2563EB; border-color: #2563EB; }
        footer { background-color: #1F2A44; color: #FFFFFF; padding: 2rem 0; text-align: center; font-family: 'Roboto', sans-serif; font-size: 1rem; }
        footer a { color: #3B82F6; text-decoration: none; margin: 0 0.5rem; }
        footer a:hover { color: #2563EB; }
        @media (max-width: 768px) { .checkout-section h2 { font-size: 2rem; } }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <section class="checkout-section py-5">
        <div class="container">
            <h2>Commande</h2>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
                <a href="index.php" class="btn btn-primary">Retourner à l'accueil</a>
            <?php elseif (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
                <a href="cart.php" class="btn btn-primary">Retour au panier</a>
            <?php else: ?>
                <p><strong>Sous-total :</strong> <?php echo number_format($subtotal, 2); ?> MAD</p>
                <p><strong>Frais de livraison :</strong> <?php echo number_format($delivery_fee, 2); ?> MAD</p>
                <p><strong>Montant total :</strong> <?php echo number_format($subtotal + $delivery_fee, 2); ?> MAD</p>
                <form method="POST" class="mx-auto" style="max-width: 500px;">
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Nom complet</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Ville</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Numéro de téléphone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Confirmer la commande (Paiement à la livraison)</button>
                </form>
            <?php endif; ?>
        </div>
    </section>
    <?php include 'includes/footer.php'; ?>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>