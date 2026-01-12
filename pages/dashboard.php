<?php 
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
requireLogin();
$pageTitle = "Dashboard";
include __DIR__ . '/../includes/header.php';

// Fetch some stats
$departements = $pdo->query("SELECT COUNT(*) as total FROM departements")->fetch()['total'];
$formations = $pdo->query("SELECT COUNT(*) as total FROM formations")->fetch()['total'];
$professeurs = $pdo->query("SELECT COUNT(*) as total FROM professeurs")->fetch()['total'];
$etudiants = $pdo->query("SELECT COUNT(*) as total FROM etudiants")->fetch()['total'];

// Get current page for navbar active state
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<?php include __DIR__ . '/../includes/navbar.php'; ?>

<div class="container mt-4">
    <div class="row g-4">

        <!-- Departements -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4" style="background: linear-gradient(135deg, #d0e2ff, #a6c8ff);">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary fw-bold">
                        <i class="bi bi-building me-2"></i>Departements
                    </h5>
                    <p class="card-text fs-2 fw-semibold text-primary"><?= $departements ?></p>
                </div>
            </div>
        </div>

        <!-- Formations -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4" style="background: linear-gradient(135deg, #d3ffd9, #8fd19e);">
                <div class="card-body text-center">
                    <h5 class="card-title text-success fw-bold">
                        <i class="bi bi-journal-text me-2"></i>Formations
                    </h5>
                    <p class="card-text fs-2 fw-semibold text-success"><?= $formations ?></p>
                </div>
            </div>
        </div>

        <!-- Professeurs -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4" style="background: linear-gradient(135deg, #fff4d6, #ffd86f);">
                <div class="card-body text-center">
                    <h5 class="card-title text-warning fw-bold">
                        <i class="bi bi-person-badge me-2"></i>Professeurs
                    </h5>
                    <p class="card-text fs-2 fw-semibold text-warning"><?= $professeurs ?></p>
                </div>
            </div>
        </div>

        <!-- Etudiants -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4" style="background: linear-gradient(135deg, #ffd6d6, #ff8f8f);">
                <div class="card-body text-center">
                    <h5 class="card-title text-danger fw-bold">
                        <i class="bi bi-people me-2"></i>Etudiants
                    </h5>
                    <p class="card-text fs-2 fw-semibold text-danger"><?= $etudiants ?></p>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Optional custom styles -->
<style>
    .card:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
    }
</style>