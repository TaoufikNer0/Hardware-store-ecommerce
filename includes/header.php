<?php
// Detect if we're in admin directory
$is_admin = strpos($_SERVER['REQUEST_URI'], '/admin/') !== false;
$base_path = $is_admin ? '../' : '';
?>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $base_path; ?>index.php">
            <img src="<?php echo $base_path; ?>assets/images/logo.png" alt="Sté CRZ Logo" style="height: 40px; width: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <?php if ($is_admin): ?>
                    <!-- Admin navigation -->
                    <li class="nav-item"><a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) === 'index.php') ? 'active' : ''; ?>" href="index.php">Tableau de Bord</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) === 'add_product.php') ? 'active' : ''; ?>" href="add_product.php">Ajouter Produit</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) === 'orders.php') ? 'active' : ''; ?>" href="orders.php">Commandes</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base_path; ?>index.php">Voir le Site</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base_path; ?>logout.php">Déconnexion</a></li>
                <?php else: ?>
                    <!-- Regular navigation -->
                    <li class="nav-item"><a class="nav-link <?php echo (isset($current_page) && $current_page === 'index') ? 'active' : ''; ?>" href="index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo (isset($current_page) && $current_page === 'products') ? 'active' : ''; ?>" href="products.php">Produits</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo (isset($current_page) && $current_page === 'cart') ? 'active' : ''; ?>" href="cart.php">Panier</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo (isset($current_page) && $current_page === 'location') ? 'active' : ''; ?>" href="location.php">Localisation</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo (isset($current_page) && $current_page === 'contact') ? 'active' : ''; ?>" href="contact.php">Contact</a></li>
                    <?php if (isLoggedIn()): ?>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <li class="nav-item"><a class="nav-link" href="admin/index.php">Admin</a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Déconnexion</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link <?php echo (isset($current_page) && $current_page === 'login') ? 'active' : ''; ?>" href="login.php">Connexion</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo (isset($current_page) && $current_page === 'register') ? 'active' : ''; ?>" href="register.php">S'inscrire</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>