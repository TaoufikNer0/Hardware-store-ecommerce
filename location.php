<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';
$current_page = 'location';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Localisation - Sté CRZ</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <style>
        .location-section {
            background-color: #F9FAFB;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .location-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: #FFFFFF;
        }
        
        .location-card h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: #1F2A44;
            margin-bottom: 1rem;
        }

        .map-container {
            width: 100%;
            height: 500px;
            border-radius: 10px;
        }

        .map-container iframe {
            border: 0;
            width: 100%;
            height: 100%;
        }
        h2{
             font-family: 'Montserrat', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: #000000;
            letter-spacing: -0.025em;
            margin-bottom: 2rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main class="flex-grow-1">
        <section class="location-section py-5">
            <div class="container">
                <h2 class="text-center mb-5" style="font-family: 'Montserrat', sans-serif;">Trouvez-nous</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="location-card p-4">
                            <h3 class="text-center">Notre Localisation</h3>
                            <p class="text-center mb-4">Imm B, Rue Oued ziz, Hay Riad, Rabat 10000, Maroc</p>
                            <div class="map-container">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3307.5761429582897!2d-5.5678502!3d33.8619165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda05bb3ed9fbddb%3A0x41257c14fd1b3510!2sComptoir%20Riad%20Zitoune!5e0!3m2!1sen!2sma!4v1625764282283!5m2!1sen!2sma" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>