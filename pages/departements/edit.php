<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $nom = trim($_POST['nom']);

    if ($id && !empty($nom)) {
        $stmt = $pdo->prepare("UPDATE departements SET nom = :nom WHERE id = :id");
        $stmt->execute(['nom' => $nom, 'id' => $id]);
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
                <i class="bi bi-pencil-square me-2 text-primary"></i> Edit Department
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
                    <input type="text" id="id" class="form-control form-control-sm" value="<?= $dep['id'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="nom" class="form-label small">Department Name</label>
                    <input type="text" name="nom" id="nom" class="form-control form-control-sm" value="<?= htmlspecialchars($dep['nom']) ?>" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-save me-1"></i> Update
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