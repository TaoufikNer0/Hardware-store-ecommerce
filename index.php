<?php

require_once 'includes/db_connect.php';

require_once 'includes/functions.php';

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sté CRZ - Hardware Store</title>

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

        .hero-section {

            padding: 3rem 0;

            background-color: #FFFFFF;

        }

        .hero-section h2 {

            font-family: 'Montserrat', sans-serif;

            font-size: 3.5rem;

            font-weight: 700;

            color: #000000;

            letter-spacing: -0.025em;

            margin-bottom: 1.5rem;

        }

        .hero-section p {

            font-family: 'Roboto', sans-serif;

            font-size: 1.25rem;

            color: #6B7280;

            margin-bottom: 2rem;

        }

        .hero-section .btn-primary {

            background-color: #3B82F6;

            border-color: #3B82F6;

            font-family: 'Roboto', sans-serif;

            font-weight: 500;

            font-size: 1.1rem;

            padding: 0.75rem 1.5rem;

            border-radius: 8px;

        }

        .hero-section .btn-primary:hover {

            background-color: #2563EB;

            border-color: #2563EB;

        }

        .hero-section .btn-outline-primary {

            color: #10B981;

            border-color: #10B981;

            font-family: 'Roboto', sans-serif;

            font-weight: 500;

            font-size: 1.1rem;

            padding: 0.75rem 1.5rem;

            border-radius: 8px;

        }

        .hero-section .btn-outline-primary:hover {

            background-color: #10B981;

            color: #FFFFFF;

            border-color: #059669;

        }

        .bsb-circle {

            background-color: #10B981 !important;

            border-radius: 50%;

        }

        .bsb-circle.border {

            border-color: #3B82F6 !important;

        }

        .bsb-btn-2xl {

            font-size: 1.1rem;

            padding: 0.75rem 1.5rem;

            border-radius: 8px;

        }

        .why-choose-us {

            padding: 5rem 0;

            background-color: #F9FAFB;

        }

        .why-choose-us h2 {

            font-family: 'Montserrat', sans-serif;

            font-size: 2.5rem;

            font-weight: 700;

            color: #000000;

            letter-spacing: -0.025em;

            margin-bottom: 3rem;

            text-align: center;

        }

        .feature-card {

            border: none;

            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);

            border-radius: 10px;

            background-color: #FFFFFF;

            transition: transform 0.3s;

            height: 100%;

            display: flex;

            flex-direction: column;

            justify-content: space-between;

        }

        .feature-card:hover {

            transform: translateY(-8px);

        }

        .feature-card svg {

            width: 48px;

            height: 48px;

            fill: #10B981;

            margin-bottom: 1.5rem;

        }

        .feature-card h3 {

            font-family: 'Montserrat', sans-serif;

            font-size: 1.5rem;

            font-weight: 700;

            color: #000000;

        }

        .feature-card p {

            font-family: 'Roboto', sans-serif;

            font-size: 1rem;

            color: #6B7280;

            flex-grow: 1;

        }

        .services-section {

            padding: 5rem 0;

            background-color: #FFFFFF;

        }

        .services-section h2 {

            font-family: 'Montserrat', sans-serif;

            font-size: 2.5rem;

            font-weight: 700;

            color: #000000;

            letter-spacing: -0.025em;

            margin-bottom: 3rem;

            text-align: center;

        }

        .service-card {

            border: none;

            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);

            border-radius: 10px;

            background-color: #FFFFFF;

            height: 100%;

            display: flex;

            flex-direction: column;

            justify-content: space-between;

        }

        .service-card img {

            width: 100%;

            height: 220px;

            object-fit: cover;

            border-radius: 10px 10px 0 0;

        }

        .service-card h3 {

            font-family: 'Montserrat', sans-serif;

            font-size: 1.5rem;

            font-weight: 700;

            color: #000000;

            margin: 1.5rem 0 1rem;

        }

        .service-card p {

            font-family: 'Roboto', sans-serif;

            font-size: 1rem;

            color: #6B7280;

            flex-grow: 1;

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

            .hero-section h2 {

                font-size: 2.5rem;

            }

            .why-choose-us h2, .services-section h2 {

                font-size: 2rem;

            }

            .feature-card h3, .service-card h3 {

                font-size: 1.25rem;

            }

            .feature-card, .service-card {

                margin-bottom: 1.5rem;

            }

        }
        h2 {
        color: #000000;
    }
    

    </style>

</head>

<body>

    <?php 
    $current_page = 'index';
    include 'includes/header.php'; 
    ?>

                </ul>

            </div>

        </div>

    </nav>

    <section class="hero-section py-3 py-lg-5 py-xl-8">

        <div class="container overflow-hidden">

            <div class="row gy-5 gy-lg-0 align-items-lg-center justify-content-lg-between">

                <div class="col-12 col-lg-6 order-1 order-lg-0">

                    <h2 class="display-3 fw-bold mb-3">Sté CRZ – Your Trusted Hardware Store</h2>

                    <p class="fs-4 mb-5">Discover top-quality tools, construction materials, and renovation supplies at Sté CRZ – Comptoir Riad Zitoune. We provide everything you need for your projects, from DIY to professional contracting.</p>

                    <div class="d-grid gap-2 d-sm-flex">

                        <a href="products.php" class="btn btn-primary bsb-btn-2xl rounded-pill">Shop Now</a>

                        <a href="contact.php" class="btn btn-outline-primary bsb-btn-2xl rounded-pill">Contact Us</a>

                    </div>

                </div>

                <div class="col-12 col-lg-5 text-center">

                    <div class="position-relative">

                        <div class="bsb-circle border border-4 position-absolute top-50 start-10 translate-middle z-1"></div>

                        <div class="bsb-circle bg-primary position-absolute top-50 start-50 translate-middle" style="--bsb-cs: 460px;"></div>

                        <div class="bsb-circle border border-4 position-absolute top-10 end-0 z-1" style="--bsb-cs: 100px;"></div>

                        <img class="img-fluid position-relative z-2" loading="lazy" src="assets/images/worker.png" alt="Hardware Store Supplies">

                    </div>

                </div>

            </div>

        </div>

    </section>
    
    <!-- This section introduces the store, pairing a large image with a descriptive text block and a call-to-action button. -->
<section class="container py-5 ">
    <div class="row align-items-start g-5">
        <div class="col-lg-6">
            <!-- Image of the store, rounded corners and a shadow for a modern look. -->
            <img src="assets/store.jpg" alt="Comptoir Riad Zitoune Store" class="img-fluid rounded-lg shadow-sm">
        </div>
        <div class="col-lg-6">
            <!-- Main heading for the section. -->
            <h2 class="display-5 fw-bold mb-3">Votre magasin de bricolage de confiance</h2>
            <!-- Lead paragraph describing the store's offerings and mission. -->
            <p class="lead">
                Chez Sté CRZ, nous sommes fiers de fournir à nos clients une vaste sélection de produits de haute qualité pour la plomberie, l'outillage, la peinture, la quincaillerie, et l'éclairage. Que vous soyez un professionnel ou un passionné de bricolage, notre équipe est là pour vous aider à trouver exactement ce dont vous avez besoin pour vos projets.
            </p>
            <!-- Call-to-action button to navigate to the products page. -->
            <a href="#!" class="btn bsb-btn-xl btn-primary rounded-pill mt-3">Découvrez notre boutique</a>
        </div>
    </div>
</section>

<!-- Products Showcase Section -->
<section class="container py-5 store-intro-section">
    <div class="row align-items-start g-5">
        <div class="col-lg-5">
            <!-- Main heading for the products section. -->
            <h2 class="display-5 fw-bold mb-3">La qualité et la fiabilité à votre service</h2>
            <p class="lead">
                Nous ne proposons que des produits issus des meilleures marques, garantissant durabilité et performance pour tous vos travaux. De l'outillage professionnel aux équipements pour la maison, chaque article est sélectionné pour sa robustesse et sa fiabilité, vous assurant des résultats à la hauteur de vos attentes.
            </p>
        </div>
        <div class="col-lg-7">
            <!-- Grid container for the product images. -->
            <div class="row row-cols-2 row-cols-md-3 g-4">
                <!-- Each column represents a product image within the grid. -->
                <div class="col">
                    <div class="card product-card">
                        <img src="assets/products1.jpg" alt="Assorted products" class="img-fluid rounded-lg">
                    </div>
                </div>
                <div class="col">
                    <div class="card product-card">
                        <img src="assets/products2.jpg" alt="Power tools" class="img-fluid rounded-lg">
                    </div>
                </div>
                <div class="col">
                    <div class="card product-card">
                        <img src="assets/products3.jpg" alt="Handheld gadgets" class="img-fluid rounded-lg">
                    </div>
                </div>
                <div class="col">
                    <div class="card product-card">
                        <img src="assets/products4.jpg" alt="Electrical supplies" class="img-fluid rounded-lg">
                    </div>
                </div>
                <div class="col">
                    <div class="card product-card">
                        <img src="assets/products7.jpg" alt="More electrical supplies" class="img-fluid rounded-lg">
                    </div>
                </div>
                <div class="col">
                    <div class="card product-card">
                        <img src="assets/products6.jpg" alt="Compressors and toilets" class="img-fluid rounded-lg">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <section class="why-choose-us py-5">

        <div class="container">

            <h2>Pourquoi nous choisir ?</h2>

            <div class="row row-cols-1 row-cols-md-3 g-4">

                <div class="col">

                    <div class="card feature-card text-center">

                        <div class="card-content">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>

                            <h3>Prix compétitifs</h3>

                            <p>Nous proposons des prix abordables sur tous les produits et locations, pour que vous obteniez le meilleur rapport qualité-prix.</p>

                        </div>

                    </div>

                </div>

                <div class="col">

                    <div class="card feature-card text-center">

                        <div class="card-content">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21 7h-6V5c0-1.1-.9-2-2-2H9c-1.1 0-2 .9-2 2v2H3v11h18V7zm-8 0H9V5h4v2z"/></svg>

                            <h3>Service de location d'outils</h3>

                            <p>Besoin d'un outil pour une journée ou une semaine ? Louez parmi notre large sélection d'équipements professionnels.</p>

                        </div>

                    </div>

                </div>

                <div class="col">

                    <div class="card feature-card text-center">
                        

                        <div class="card-content">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>

                            <h3>Marques de qualité</h3>

                            <p>Nous ne stockons que des marques reconnues pour leur durabilité et leurs performances.</p>

                        </div>

                    </div>

                </div>

                <div class="col">

                    <div class="card feature-card text-center">

                        <div class="card-content">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-3.33 0-10 1.67-10 5v2h20v-2c0-3.33-6.67-5-10-5z"/></svg>

                            <h3>Satisfaction client</h3>

                            <p>Nous sommes fiers de notre excellent service et de nos clients satisfaits — découvrez pourquoi tant de personnes nous font confiance !</p>

                        </div>

                    </div>

                </div>

                <div class="col">

                    <div class="card feature-card text-center">

                        <div class="card-content">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>

                            <h3>Garantie qualité</h3>

                            <p>Produits de qualité supérieure avec garantie.</p>

                        </div>

                    </div>

                </div>

                <div class="col">

                    <div class="card feature-card text-center">

                        <div class="card-content">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 5h-2v2h2v-2zm0 4h-2v2h2v-2zm-4-4h-2v2h2V7zm0 4h-2v2h2v-2zm-4-4H7v2h2V7zm0 4H7v2h2v-2z"/></svg>

                            <h3>Conseil expert</h3>

                            <p>Notre équipe d'experts vous guide dans le choix des meilleurs produits et solutions pour vos projets spécifiques.</p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <section class="services-section py-5">

        <div class="container">

            <h2>Nos Services</h2>

            <div class="row row-cols-1 row-cols-md-3 g-4">

                <div class="col">

                    <div class="card service-card text-center">

                        <img src="assets/images/painting.jpg" alt="Painting Service" class="img-fluid">

                        <div class="card-content">

                            <h3>Peinture</h3>

                            <p>Services de peinture professionnels pour maisons et entreprises. Nous utilisons des matériaux de qualité et garantissons une finition propre et soignée à chaque fois.</p>

                        </div>

                    </div>

                </div>

                <div class="col">

                    <div class="card service-card text-center">

                        <img src="assets/images/plumbing.jpg" alt="Plumbing Service" class="img-fluid">

                        <div class="card-content">

                            <h3>Plomberie</h3>

                            <p>Solutions de plomberie expertes pour réparations, installations et urgences. Service rapide, fiable et abordable pour vos besoins.</p>

                        </div>
                        

                    </div>

                </div>

                <div class="col">

                    <div class="card service-card text-center">

                        <img src="assets/images/tools.jpeg" alt="Tools Service" class="img-fluid">

                        <div class="card-content">

                            <h3>Vente d'outils</h3>

                            <p>Large choix d'outils professionnels à louer. Parfait pour les projets de bricolage ou les entrepreneurs ayant besoin du bon équipement.</p>

                        </div>

                    </div>

                </div>

                <div class="col">

                    <div class="card service-card text-center">

                        <img src="assets/images/bricolage.jpg" alt="Bricolage Service" class="img-fluid">

                        <div class="card-content">

                            <h3>Bricolage</h3>

                            <p>Services complets de bricolage et d'amélioration de l'habitat. Des petites réparations aux grandes rénovations, nos artisans qualifiés s'occupent de tout avec précision et soin.</p>

                        </div>

                    </div>

                </div>

                <div class="col">

                    <div class="card service-card text-center">

                        <img src="assets/images/electricity.jpg" alt="Electricity Service" class="img-fluid">

                        <div class="card-content">

                            <h3>Électricité</h3>

                            <p>Services électriques professionnels pour installations, réparations et maintenance. Nos électriciens certifiés assurent un travail sûr et fiable pour votre maison ou entreprise.</p>

                        </div>

                    </div>

                </div>

                <div class="col">

                    <div class="card service-card text-center">

                        <img src="assets/images/team.jpg" alt="Installation and Repair Service" class="img-fluid">

                        <div class="card-content">

                            <h3>Installation et réparation</h3>

                            <p>Services professionnels d'installation et de réparation pour tous vos équipements. Notre équipe qualifiée assure un travail de qualité et une installation sécurisée.</p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://unpkg.com/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>