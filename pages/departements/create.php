<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    if (!empty($nom)) {
        $stmt = $pdo->prepare("INSERT INTO departements (nom) VALUES (:nom)");
        $stmt->execute(['nom' => $nom]);

        // Reindex IDs
        $pdo->exec("SET @count = 0");
        $pdo->exec("UPDATE departements SET id = (@count:=@count+1) ORDER BY id");

        header("Location: index.php");
        exit;
    }
}
header("Location: index.php");
exit;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-sm p-4" style="width: 360px;">
            <h4 class="text-center mb-3">
                <i class="bi bi-building me-2 text-primary"></i> Add New Department
            </h4>

            <?php if ($error): ?>
                <div class="alert alert-danger small mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i><?= $error ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success small mb-3">
                    <i class="bi bi-check-circle-fill me-1"></i><?= $success ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="id" class="form-label small">Department ID</label>
                    <input type="text" id="id" class="form-control form-control-sm" value="<?= $nextId ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="nom" class="form-label small">Department Name</label>
                    <input type="text" name="nom" id="nom" class="form-control form-control-sm" placeholder="Enter department name" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add
                    </button>
                    <a href="index.php" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left-circle me-1"></i> Back
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>