<?php
// Start session (called once here)
session_start();

// Include functions (which includes config.php)
require_once 'includes/functions.php';

try {
    // Clear all session data
    $_SESSION = [];
    
    // Destroy the session
    if (session_destroy()) {
        // Redirect to home page
        redirect('index.php');
    } else {
        throw new Exception("Échec de la destruction de la session.");
    }
} catch (Exception $e) {
    $error = "Déconnexion échouée : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur de Déconnexion - Sté CRZ</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include 'includes/header.php'; ?>
    <main class="flex-grow-1">
        <section class="error-section py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-4" style="font-family: 'Montserrat', sans-serif;">Erreur de Déconnexion</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger text-center mx-auto" style="max-width: 500px;"><?php echo $error; ?></div>
                <?php endif; ?>
                <div class="text-center">
                    <a href="index.php" class="btn btn-primary">Retour à l'Accueil</a>
                </div>
            </div>
        </section>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>