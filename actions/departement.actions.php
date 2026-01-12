<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
requireLogin();

// Only allow admin to delete
if (!isAdmin()) {
    header('HTTP/1.1 403 Forbidden');
    exit('Access denied');
}

// Check if 'id' is provided
if (isset($_GET['id'])) {
    $id = (int) $_GET['id']; // sanitize input

    // Directly delete the record
    $stmt = $pdo->prepare("DELETE FROM departements WHERE id = ?");
    $stmt->execute([$id]);
}

// Redirect back to departements list
header("Location: ../pages/departements/index.php");
exit;
