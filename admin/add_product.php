<?php
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if (!isLoggedIn() || $_SESSION['role'] !== 'admin') {
    redirect('../index.php');
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $category_id = intval($_POST['category_id']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $shipping_fee = floatval($_POST['shipping_fee']);
    $description = sanitize($_POST['description']);

    if (empty($name) || $category_id <= 0 || $price <= 0 || $stock < 0 || $shipping_fee < 0 || empty($_FILES['image']['name'])) {
        $errors[] = "Tous les champs sont obligatoires et le prix/stock/frais de livraison doivent être valides.";
    } else {
        $image = $_FILES['image']['name'];
        $target = "../assets/images/" . basename($image);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $stmt = $pdo->prepare("INSERT INTO products (name, category_id, price, stock, shipping_fee, description, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $category_id, $price, $stock, $shipping_fee, $description, $image]);
            redirect('index.php');
        } else {
            $errors[] = "Échec du téléchargement de l'image.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit - Sté CRZ</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; color: #1F2A44; background-color: #F9FAFB; }
        .navbar { background-color: #FFFFFF; position: sticky; top: 0; z-index: 1030; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .navbar-brand img { height: 40px; }
        .nav-link { color: #000000 !important; font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 1.1rem; padding: 0.5rem 1rem; transition: color 0.3s; }
        .nav-link:hover, .nav-link.active { color: #3B82F6 !important; }
        .add-product-section { padding: 3rem 0; background-color: #FFFFFF; }
        .add-product-section h2 { font-family: 'Montserrat', sans-serif; font-size: 2.5rem; font-weight: 700; color: #000000; margin-bottom: 2rem; text-align: center; }
        .add-product-section .btn-primary { background-color: #3B82F6; border-color: #3B82F6; font-family: 'Roboto', sans-serif; font-weight: 500; font-size: 1.1rem; padding: 0.75rem 1.5rem; border-radius: 8px; }
        .add-product-section .btn-primary:hover { background-color: #2563EB; border-color: #2563EB; }
        footer { background-color: #1F2A44; color: #FFFFFF; padding: 2rem 0; text-align: center; font-family: 'Roboto', sans-serif; font-size: 1rem; }
        footer a { color: #3B82F6; text-decoration: none; margin: 0 0.5rem; }
        footer a:hover { color: #2563EB; }
        @media (max-width: 768px) { .add-product-section h2 { font-size: 2rem; } .add-product-section .form-label { font-size: 1rem; } }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <section class="add-product-section py-5">
        <div class="container">
            <h2>Ajouter un Nouveau Produit</h2>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 500px;">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du Produit</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Catégorie</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Sélectionner une Catégorie</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Prix (MAD)</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Quantité en Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" required>
                </div>
                <div class="mb-3">
                    <label for="shipping_fee" class="form-label">Frais de Livraison (MAD)</label>
                    <input type="number" step="0.01" class="form-control" id="shipping_fee" name="shipping_fee" min="0" value="0.00" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image du Produit</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ajouter le Produit</button>
            </form>
        </div>
    </section>
    
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>