<?php
require_once 'includes/auth.php';

// Ensure user is logged in
requireLogin();

$page = $_GET['page'] ?? 'dashboard';
$valid_pages = [
    'dashboard',
  
];

// Only include valid pages
$content_page = in_array($page, $valid_pages) && is_file("pages/$page/index.php")
    ? "pages/$page/index.php"
    : "pages/dashboard.php";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning des Examens12</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  
    <?php  ?>

    <main class="container mt-4">
        <?php include $content_page; ?>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>