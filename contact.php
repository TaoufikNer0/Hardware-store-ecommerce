<?php
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';
$current_page = 'contact';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous - Sté CRZ</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <style>
        .contact-details-card {
            background-color: #FFFFFF;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;

        }

        .contact-details-card .contact-item {
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .contact-details-card .contact-item i {
            font-size: 1.5rem;
            color: #3B82F6;
            margin-right: 1rem;
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
        <section class="contact-section py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8">
                        <h2 class="text-center mb-5" style="font-family: 'Montserrat', sans-serif;">Contactez-nous</h2>
                        <div class="contact-details-card h-100">
                            <h3 class="mb-4">Informations de contact</h3>
                            <div class="contact-item">
                                <i class="bi bi-geo-alt"></i>
                                <div>
                                    <h5 class="mb-1">Adresse</h5>
                                    <p class="mb-0">Imm B, Rue Oued ziz, Hay Riad, Rabat 10000, Maroc</p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="bi bi-phone"></i>
                                <div>
                                    <h5 class="mb-1">Téléphone</h5>
                                    <p class="mb-0"><a href="tel:+212537671110" class="text-decoration-none">+212 537 671110</a></p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="bi bi-envelope"></i>
                                <div>
                                    <h5 class="mb-1">Email</h5>
                                    <p class="mb-0"><a href="mailto:contact@ste-crz.com" class="text-decoration-none">contact@ste-crz.com</a></p>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="bi bi-whatsapp"></i>
                                <div>
                                    <h5 class="mb-1">WhatsApp</h5>
                                    <p class="mb-0"><a href="https://wa.me/212661557022" target="_blank" class="text-decoration-none">+212 661 557022</a></p>
                                </div>
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