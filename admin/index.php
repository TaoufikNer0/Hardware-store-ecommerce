<?php
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    redirect('../index.php');
}

$stmt = $pdo->query("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin - Sté CRZ</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/heroes/hero-3/assets/css/hero-3.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
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
        .dashboard-section {
            padding: 3rem 0;
            background-color: #FFFFFF;
        }
        .dashboard-section h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: #000000;
            letter-spacing: -0.025em;
            margin-bottom: 2rem;
            text-align: center;
        }
        .dashboard-card {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #FFFFFF;
            transition: transform 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
        }
        .dashboard-card:hover {
            transform: translateY(-8px);
        }
        .dashboard-card svg {
            width: 48px;
            height: 48px;
            fill: #10B981;
            margin-bottom: 1.5rem;
        }
        .dashboard-card h3 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #000000;
        }
        .dashboard-card p {
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
            color: #6B7280;
            flex-grow: 1;
        }
        .dashboard-card .btn-primary {
            background-color: #3B82F6;
            border-color: #3B82F6;
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
        }
        .dashboard-card .btn-primary:hover {
            background-color: #2563EB;
            border-color: #2563EB;
        }
        .dashboard-card .btn-danger {
            background-color: #EF4444;
            border-color: #EF4444;
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
        }
        .dashboard-card .btn-danger:hover {
            background-color: #DC2626;
            border-color: #DC2626;
        }
        .product-table th, .product-table td {
            vertical-align: middle;
        }
        .product-table img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .product-table .btn-sm {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
        .card-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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
            .dashboard-section h2 {
                font-size: 2.5rem;
            }
            .dashboard-card h3 {
                font-size: 1.25rem;
            }
            .dashboard-card {
                margin-bottom: 1.5rem;
            }
            .product-table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <section class="dashboard-section py-3 py-lg-5 py-xl-8">
        <div class="container">
            <h2>Tableau de Bord Admin</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
                <div class="col">
                    <div class="card dashboard-card text-center">
                        <div class="card-content">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 7h-6V5c0-1.1-.9-2-2-2H9c-1.1 0-2 .9-2 2v2H3v11h18V7zm-8 0H9V5h4v2z"/></svg>
                            <h3>Ajouter un Produit</h3>
                            <p>Ajouter un nouveau produit au magasin.</p>
                            <a href="add_product.php" class="btn btn-primary">Ajouter</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card dashboard-card text-center">
                        <div class="card-content">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 11H8v-2h4v2zm4 0h-4v-2h4v2zm4 0h-4v-2h4v2zM12 9H8V7h4v2zm4 0h-4V7h4v2zm4 0h-4V7h4v2z"/></svg>
                            <h3>Gérer les Commandes</h3>
                            <p>Voir et mettre à jour les commandes clients.</p>
                            <a href="orders.php" class="btn btn-primary">Voir Commandes</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card dashboard-card text-center">
                        <div class="card-content">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10 9V5l-7 7 7 7v-4.1c5 0 8.5 1.6 11 5.1-1-5-4-10-11-11z"/></svg>
                            <h3>Déconnexion</h3>
                            <p>Se déconnecter du tableau de bord admin.</p>
                            <a href="../logout.php" class="btn btn-danger">Déconnexion</a>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="text-center mb-4">Gérer les Produits</h3>
            <div class="card">
                <div class="card-content">
                    <?php if (empty($products)): ?>
                        <p class="text-center">Aucun produit disponible.</p>
                    <?php else: ?>
                        <table class="table table-bordered product-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Nom</th>
                                    <th>Catégorie</th>
                                    <th>Prix (MAD)</th>
                                    <th>Stock</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"></td>
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                        <td><?php echo number_format($product['price'], 2); ?></td>
                                        <td><?php echo $product['stock']; ?></td>
                                        <td>
                                            <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm">Modifier</a>
                                            <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>