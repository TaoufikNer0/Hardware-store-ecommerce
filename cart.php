<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';
$current_page = 'cart';

// Handle quantity updates
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $qty) {
        $qty = (int)$qty;
        if ($qty > 0) {
            // Check stock before updating
            $stmt = $pdo->prepare("SELECT stock FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($product && $qty <= $product['stock']) {
                $_SESSION['cart'][$id] = $qty;
            } else {
                $errors[] = "Quantité invalide pour le produit ID $id. Stock maximum: {$product['stock']}.";
            }
        } else {
            unset($_SESSION['cart'][$id]); // Remove item if quantity is 0
        }
    }
    redirect('cart.php');
}

$cart_items = [];
$total = 0;
$total_shipping = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product) {
        $quantity = $_SESSION['cart'][$product['id']];
        $subtotal = $product['price'] * $quantity;
        $shipping = $product['shipping_fee'] * $quantity;
        $cart_items[] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'image' => $product['image'],
            'price' => $product['price'],
            'shipping_fee' => $product['shipping_fee'],
            'quantity' => $quantity,
            'subtotal' => $subtotal,
            'shipping' => $shipping
        ];
        $total += $subtotal;
        $total_shipping += $shipping;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - Sté CRZ</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include 'includes/header.php'; ?>
    <main class="flex-grow-1">
        <section class="cart-section py-3 py-lg-5 py-xl-8">
            <div class="container">
                <h2>Votre Panier</h2>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if (empty($cart_items)): ?>
                    <p class="text-center">Votre panier est vide.</p>
                    <div class="text-center">
                        <a href="products.php" class="btn btn-primary">Retour aux Produits</a>
                    </div>
                <?php else: ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Produit</th>
                                <th>Prix Unitaire</th>
                                <th>Frais de Livraison</th>
                                <th>Quantité</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item): ?>
                                <tr>
                                    <td><img src="assets/images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="max-width: 100px;"></td>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td><?php echo number_format($item['price'], 2); ?> MAD</td>
                                    <td><?php echo number_format($item['shipping_fee'], 2); ?> MAD</td>
                                    <td>
                                        <form method="POST" action="">
                                            <input type="number" name="quantity[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="form-control quantity-input" data-price="<?php echo $item['price']; ?>" style="width: 100px; display: inline-block;">
                                            <button type="submit" name="update_cart" class="btn btn-sm btn-secondary">Mettre à jour</button>
                                        </form>
                                    </td>
                                    <td class="subtotal"><?php echo number_format($item['subtotal'] + $item['shipping'], 2); ?> MAD</td>
                                    <td>
                                        <a href="remove_from_cart.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Retirer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end"><strong>Sous-total:</strong></td>
                                <td id="cart-subtotal"><?php echo number_format($total, 2); ?> MAD</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-end"><strong>Total Livraison:</strong></td>
                                <td><?php echo number_format($total_shipping, 2); ?> MAD</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-end"><strong>Total:</strong></td>
                                <td id="cart-total"><?php echo number_format($total + $total_shipping, 2); ?> MAD</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="text-end">
                        <a href="products.php" class="btn btn-outline-primary">Continuer vos Achats</a>
                        <a href="checkout.php" class="btn btn-primary">Passer Commande</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>
</body>
</html>