<?php
require_once __DIR__ . '/auth.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$currentPage = basename($_SERVER['PHP_SELF']);
$user = $_SESSION['user'] ?? null;
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand fw-bold d-flex align-items-center text-primary" href="/exams-planning/pages/dashboard.php">
            <i class="bi bi-mortarboard-fill me-2"></i>Exams Planning
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <?php if ($user && $user['role'] === 'admin'): ?>
                    <li class="nav-item mx-1">
                        <a class="nav-link btn btn-outline-primary btn-sm px-3 rounded-pill <?= strpos($currentPage, 'departements') !== false ? 'active' : ''; ?>"
                            href="/exams-planning/pages/departements/index.php">
                            <i class="bi bi-building me-1"></i>Departements
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link btn btn-outline-primary btn-sm px-3 rounded-pill <?= strpos($currentPage, 'formations') !== false ? 'active' : ''; ?>"
                            href="/exams-planning/pages/formations/index.php">
                            <i class="bi bi-journal-text me-1"></i>Formations
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link btn btn-outline-primary btn-sm px-3 rounded-pill <?= strpos($currentPage, 'examens') !== false ? 'active' : ''; ?>"
                            href="/exams-planning/pages/examens/index.php">
                            <i class="bi bi-pencil-square me-1"></i>Examens
                        </a>
                    </li>

                <?php elseif ($user && $user['role'] === 'prof'): ?>
                    <li class="nav-item mx-1">
                        <a class="nav-link btn btn-outline-primary btn-sm px-3 rounded-pill <?= strpos($currentPage, 'examens') !== false ? 'active' : ''; ?>"
                            href="/exams-planning/pages/examens/index.php">
                            <i class="bi bi-pencil-square me-1"></i>My Exams
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link btn btn-outline-primary btn-sm px-3 rounded-pill <?= strpos($currentPage, 'surveillances') !== false ? 'active' : ''; ?>"
                            href="/exams-planning/pages/surveillances/index.php">
                            <i class="bi bi-eye me-1"></i>Supervision
                        </a>
                    </li>

                <?php elseif ($user && $user['role'] === 'student'): ?>
                    <li class="nav-item mx-1">
                        <a class="nav-link btn btn-outline-primary btn-sm px-3 rounded-pill <?= strpos($currentPage, 'inscriptions') !== false ? 'active' : ''; ?>"
                            href="/exams-planning/pages/inscriptions/index.php">
                            <i class="bi bi-card-checklist me-1"></i>My Modules
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link btn btn-outline-primary btn-sm px-3 rounded-pill <?= strpos($currentPage, 'examens') !== false ? 'active' : ''; ?>"
                            href="/exams-planning/pages/examens/index.php">
                            <i class="bi bi-pencil-square me-1"></i>My Exams
                        </a>
                    </li>
                <?php endif; ?>

                <!-- User dropdown -->
                <?php if ($user): ?>
                    <li class="nav-item dropdown mx-1">
                        <a class="nav-link dropdown-toggle btn btn-outline-secondary btn-sm px-3 rounded-pill d-flex align-items-center"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>
                            <?= htmlspecialchars($user['name']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/exams-planning/logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<!-- Custom CSS -->
<style>
    /* Active nav link */
    .navbar-nav .nav-link.active {
        background-color: #d0e4ff;
        color: #0d6efd !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
    }

    /* Hover effect for buttons */
    .navbar-nav .nav-link.btn-outline-primary:hover {
        background-color: #e3f0ff;
        color: #0d6efd;
        transform: translateY(-2px);
        transition: all 0.2s ease;
    }

    /* Dropdown menu */
    .dropdown-menu {
        min-width: 12rem;
        border-radius: 0.75rem;
        padding: 0.5rem 0;
    }

    .dropdown-item:hover {
        background-color: #f1f5ff;
    }
</style>