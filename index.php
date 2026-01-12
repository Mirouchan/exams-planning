<?php
session_start(); // Always start session first
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning des Examens</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/navbar.php'; ?>

    <main class="container mt-4">
        <?php
        if (!isset($_SESSION['user_id'])) {
            include 'login.php';
        } else {
            $page = $_GET['page'] ?? 'dashboard';
            $valid_pages = [
                'dashboard',
                'departements',
                'formations',
                'professeurs',
                'modules',
                'etudiants',
                'inscriptions',
                'lieux',
                'sessions',
                'jours',
                'examens',
                'surveillances',
                'conflits',
                'profile'
            ];

            if (in_array($page, $valid_pages) && is_file("pages/$page/index.php")) {
                include "pages/$page/index.php";
            } else {
                include 'pages/dashboard.php';
            }
        }
        ?>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>