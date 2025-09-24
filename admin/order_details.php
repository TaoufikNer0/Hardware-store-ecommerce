<?php
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    redirect('../index.php');
}

$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$errors = [];
$success = '';

if (!$order_id) {
    $errors[] = "ID de commande invalide.";
} else {
    $stmt = $pdo->prepare("SELECT o.*, u.username FROM orders o LEFT JOIN users u ON o.user_id = u.id WHERE o.id = ?");
    $stmt->execute([$order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        $errors[] = "Commande non trouvée.";
    } else {
        $stmt = $pdo->prepare("SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
        $stmt->execute([$order_id]);
        $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['update_status'])) {
            $status = sanitize($_POST['status']);
            $valid_statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
            if (in_array($status, $valid_statuses)) {
                try {
                    $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?")->execute([$status, $order_id]);
                    $success = "Statut de la commande mis à jour : $status.";
                    $order['status'] = $status;
                } catch (Exception $e) {
                    $errors[] = "Échec de la mise à jour du statut : " . htmlspecialchars($e->getMessage());
                }
            } else {
                $errors[] = "Statut sélectionné invalide.";
            }
        } elseif (isset($_POST['delete_order'])) {
            try {
                $pdo->beginTransaction();
                $pdo->prepare("DELETE FROM order_items WHERE order_id = ?")->execute([$order_id]);
                $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$order_id]);
                $pdo->commit();
                redirect('orders.php?message=Commande supprimée avec succès');
            } catch (Exception $e) {
                $pdo->rollBack();
                $errors[] = "Échec de la suppression de la commande : " . htmlspecialchars($e->getMessage());
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
    <title>Détails Commande - #<?php echo $order_id; ?> - Sté CRZ</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; color: #1F2A44; background-color: #F9FAFB; }
        .navbar { background-color: #FFFFFF; position: sticky; top: 0; z-index: 1030; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .navbar-brand img { height: 40px; }
        .nav-link { color: #000000 !important; font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 1.1rem; padding: 0.5rem 1rem; transition: color 0.3s; }
        .nav-link:hover, .nav-link.active { color: #3B82F6 !important; }
        .order-details-section { padding: 2rem 0; background-color: #FFFFFF; }
        .order-details-section h2 { font-family: 'Montserrat', sans-serif; font-size: 2rem; font-weight: 700; color: #000000; margin-bottom: 1.5rem; }
        .btn-primary { background-color: #3B82F6; border-color: #3B82F6; font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 0.9rem; padding: 0.5rem 1rem; border-radius: 6px; }
        .btn-primary:hover { background-color: #2563EB; border-color: #2563EB; }
        .btn-danger { background-color: #EF4444; border-color: #EF4444; font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 0.9rem; padding: 0.5rem 1rem; border-radius: 6px; }
        .btn-danger:hover { background-color: #DC2626; border-color: #DC2626; }
        .card { border: none; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; }
        .table img { width: 40px; height: auto; }
        footer { background-color: #1F2A44; color: #FFFFFF; padding: 1.5rem 0; text-align: center; font-family: 'Roboto', sans-serif; font-size: 0.9rem; }
        footer a { color: #3B82F6; text-decoration: none; margin: 0 0.5rem; }
        footer a:hover { color: #2563EB; }
        @media (max-width: 768px) { .order-details-section h2 { font-size: 1.5rem; } .table { font-size: 0.85rem; } }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <section class="order-details-section">
        <div class="container">
            <h2>Commande #<?php echo $order_id; ?></h2>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                </div>
            <?php elseif ($order): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <p><strong>Utilisateur :</strong> <?php echo $order['username'] ? htmlspecialchars($order['username']) : 'Invité'; ?></p>
                        <p><strong>Client :</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                        <p><strong>Adresse :</strong> <?php echo htmlspecialchars($order['address'] . ', ' . $order['city']); ?></p>
                        <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                        <p><strong>Montant Total :</strong> <?php echo number_format($order['total_amount'], 2); ?> MAD</p>
                        <p><strong>Frais de Livraison :</strong> <?php echo number_format($order['delivery_fee'], 2); ?> MAD</p>
                        <p><strong>Statut :</strong> <?php echo htmlspecialchars($order['status']); ?></p>
                        <p><strong>Date :</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>
                    </div>
                </div>
                <h3>Articles</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Produit</th>
                            <th>Qté</th>
                            <th>Prix</th>
                            <th>Livraison</th>
                            <th>Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $item): ?>
                            <tr>
                                <td><img src="../assets/images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo number_format($item['price'], 2); ?> MAD</td>
                                <td><?php echo number_format($item['shipping_fee'] ?? 0, 2); ?> MAD</td>
                                <td><?php echo number_format($item['quantity'] * ($item['price'] + ($item['shipping_fee'] ?? 0)), 2); ?> MAD</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <form method="POST" class="mb-3">
                    <div class="mb-3">
                        <label for="status" class="form-label">Statut</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>En attente</option>
                            <option value="processing" <?php echo $order['status'] === 'processing' ? 'selected' : ''; ?>>En traitement</option>
                            <option value="shipped" <?php echo $order['status'] === 'shipped' ? 'selected' : ''; ?>>Expédiée</option>
                            <option value="delivered" <?php echo $order['status'] === 'delivered' ? 'selected' : ''; ?>>Livrée</option>
                            <option value="cancelled" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Annulée</option>
                        </select>
                    </div>
                    <button type="submit" name="update_status" class="btn btn-primary">Mettre à jour</button>
                    <button type="submit" name="delete_order" class="btn btn-danger" onclick="return confirm('Supprimer cette commande ? Cette action ne peut pas être annulée.');">Supprimer</button>
                </form>
            <?php endif; ?>
            <a href="orders.php" class="btn btn-primary">Retour aux Commandes</a>
        </div>
    </section>
    
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>