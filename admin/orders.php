<?php
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    redirect('../index.php');
}

$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';
$where = '';
$params = [];

if ($search) {
    $where = "WHERE o.id LIKE ? OR o.customer_name LIKE ?";
    $params = ["%$search%", "%$search%"];
}

$stmt = $pdo->prepare("SELECT o.*, u.username FROM orders o LEFT JOIN users u ON o.user_id = u.id $where ORDER BY o.created_at DESC");
$stmt->execute($params);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    try {
        $pdo->beginTransaction();
        $pdo->prepare("DELETE FROM order_items WHERE order_id = ?")->execute([$delete_id]);
        $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$delete_id]);
        $pdo->commit();
        redirect('orders.php?message=Commande supprimée avec succès');
    } catch (Exception $e) {
        $pdo->rollBack();
        redirect('orders.php?error=Échec de la suppression de la commande: ' . htmlspecialchars($e->getMessage()));
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Commandes - Sté CRZ</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; color: #1F2A44; background-color: #F9FAFB; }
        .navbar { background-color: #FFFFFF; position: sticky; top: 0; z-index: 1030; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .navbar-brand img { height: 40px; }
        .nav-link { color: #000000 !important; font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 1.1rem; padding: 0.5rem 1rem; transition: color 0.3s; }
        .nav-link:hover, .nav-link.active { color: #3B82F6 !important; }
        .orders-section { padding: 2rem 0; background-color: #FFFFFF; }
        .orders-section h2 { font-family: 'Montserrat', sans-serif; font-size: 2rem; font-weight: 700; color: #000000; margin-bottom: 1.5rem; }
        .btn-primary { background-color: #3B82F6; border-color: #3B82F6; font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 0.9rem; padding: 0.5rem 1rem; border-radius: 6px; }
        .btn-primary:hover { background-color: #2563EB; border-color: #2563EB; }
        .btn-danger { background-color: #EF4444; border-color: #EF4444; font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 0.9rem; padding: 0.5rem 1rem; border-radius: 6px; }
        .btn-danger:hover { background-color: #DC2626; border-color: #DC2626; }
        .card { border: none; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; }
        .table { font-size: 0.9rem; }
        footer { background-color: #1F2A44; color: #FFFFFF; padding: 1.5rem 0; text-align: center; font-family: 'Roboto', sans-serif; font-size: 0.9rem; }
        footer a { color: #3B82F6; text-decoration: none; margin: 0 0.5rem; }
        footer a:hover { color: #2563EB; }
        @media (max-width: 768px) { .orders-section h2 { font-size: 1.5rem; } .table { font-size: 0.8rem; } }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <section class="orders-section">
        <div class="container">
            <h2>Gérer les Commandes</h2>
            <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>
            <form method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher par ID commande ou client" value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </form>
            <div class="card">
                <div class="card-body">
                    <?php if (empty($orders)): ?>
                        <p>Aucune commande trouvée.</p>
                    <?php else: ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>Total</th>
                                    <th>Frais Livraison</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?php echo $order['id']; ?></td>
                                        <td><?php echo htmlspecialchars($order['customer_name']); ?> (<?php echo $order['username'] ? htmlspecialchars($order['username']) : 'Invité'; ?>)</td>
                                        <td><?php echo number_format($order['total_amount'], 2); ?> MAD</td>
                                        <td><?php echo number_format($order['delivery_fee'], 2); ?> MAD</td>
                                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                                        <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                                        <td>
                                            <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-primary btn-sm">Voir</a>
                                            <a href="orders.php?delete_id=<?php echo $order['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette commande ? Cette action ne peut pas être annulée.');">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
            <a href="index.php" class="btn btn-primary mt-3">Retour au Tableau de Bord</a>
        </div>
    </section>
 
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>