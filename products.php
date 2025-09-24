<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';

$stmt = $pdo->query("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits - Sté CRZ</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/heroes/hero-3/assets/css/hero-3.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
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
        .products-section {
            padding: 3rem 0;
            background-color: #FFFFFF;
        }
        .products-section h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: #000000;
            letter-spacing: -0.025em;
            margin-bottom: 2rem;
            text-align: center;
        }
        .product-card {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #FFFFFF;
            transition: transform 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .product-card:hover {
            transform: translateY(-8px);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }
        .product-card h3 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #000000;
            margin: 1.5rem 0 1rem;
        }
        .product-card p {
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
            color: #6B7280;
            flex-grow: 1;
        }
        .product-card .btn-primary {
            background-color: #3B82F6;
            border-color: #3B82F6;
            font-family: 'Roboto', sans-serif;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
        }
        .product-card .btn-primary:hover {
            background-color: #2563EB;
            border-color: #2563EB;
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
            .products-section h2 {
                font-size: 2.5rem;
            }
            .product-card h3 {
                font-size: 1.25rem;
            }
            .product-card {
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <section class="products-section py-3 py-lg-5 py-xl-8">
        <div class="container">
            <h2>Nos produits</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($products as $product): ?>
                    <div class="col">
                        <div class="card product-card text-center">
                            <img src="assets/images/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <div class="card-content">
                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p><?php echo htmlspecialchars($product['category_name']); ?> | <?php echo number_format($product['price'], 2); ?> MAD</p>
                                <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">Voir les détails</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php include 'includes/footer.php'; ?>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>