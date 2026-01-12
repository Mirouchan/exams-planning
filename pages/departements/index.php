<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/auth.php';
requireLogin();

// Handle delete directly without JS confirm
if (isset($_GET['delete_id']) && isAdmin()) {
    $delete_id = (int) $_GET['delete_id'];
    $pdo->prepare("DELETE FROM departements WHERE id = ?")->execute([$delete_id]);

    // Reindex IDs
    $pdo->exec("SET @count = 0");
    $pdo->exec("UPDATE departements SET id = (@count:=@count+1) ORDER BY id");

    header("Location: index.php");
    exit;
}

// Fetch departments
$departements = $pdo->query("SELECT * FROM departements ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include __DIR__ . '/../../includes/header.php'; ?>
<?php include __DIR__ . '/../../includes/navbar.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-building me-2 text-primary"></i>Departments</h2>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus-circle me-1"></i> Add New
        </button>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($departements): ?>
                <?php foreach ($departements as $dep): ?>
                    <tr>
                        <td><?= $dep['id'] ?></td>
                        <td><?= htmlspecialchars($dep['nom']) ?></td>
                        <td><?= $dep['created_at'] ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $dep['id'] ?>">
                                <i class="bi bi-pencil-square me-1"></i>Edit
                            </button>
                            <a href="?delete_id=<?= $dep['id'] ?>" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash me-1"></i>Delete
                            </a>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?= $dep['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="edit.php">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="bi bi-pencil-square me-1"></i>Edit Department</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $dep['id'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label small">Department Name</label>
                                            <input type="text" name="nom" class="form-control form-control-sm" value="<?= htmlspecialchars($dep['nom']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary btn-sm" type="submit">
                                            <i class="bi bi-save me-1"></i> Update
                                        </button>
                                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No departments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="create.php">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-building me-1"></i>Add Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small">Department Name</label>
                        <input type="text" name="nom" class="form-control form-control-sm" placeholder="Enter name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-sm" type="submit"><i class="bi bi-plus-circle me-1"></i>Add</button>
                    <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>