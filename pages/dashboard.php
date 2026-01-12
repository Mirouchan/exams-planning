<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
requireLogin();

$pageTitle = "Dashboard";
require_once '../includes/header.php';
require_once '../includes/navbar.php';

// Get statistics
$stats = [];

// Total Departments
$stmt = $pdo->query("SELECT COUNT(*) as total FROM departements");
$stats['departements'] = $stmt->fetch()['total'];

// Total Formations
$stmt = $pdo->query("SELECT COUNT(*) as total FROM formations");
$stats['formations'] = $stmt->fetch()['total'];

// Total Professors
$stmt = $pdo->query("SELECT COUNT(*) as total FROM professeurs");
$stats['professeurs'] = $stmt->fetch()['total'];

// Total Students
$stmt = $pdo->query("SELECT COUNT(*) as total FROM etudiants");
$stats['etudiants'] = $stmt->fetch()['total'];

// Total Exams
$stmt = $pdo->query("SELECT COUNT(*) as total FROM examens");
$stats['examens'] = $stmt->fetch()['total'];

// Upcoming Exams
$stmt = $pdo->query("SELECT COUNT(*) as total FROM examens WHERE date_heure > NOW()");
$stats['upcoming_exams'] = $stmt->fetch()['total'];

// Pending Conflicts
$stmt = $pdo->query("SELECT COUNT(*) as total FROM conflits_edt WHERE statut = 'NON_RESOLU'");
$stats['conflits'] = $stmt->fetch()['total'];

// Active Sessions
$stmt = $pdo->query("SELECT COUNT(*) as total FROM sessions WHERE statut = 'EN_COURS'");
$stats['sessions_actives'] = $stmt->fetch()['total'];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 sidebar">
            <div class="d-flex flex-column flex-shrink-0 p-3">
                <h4 class="mb-3">Menu Rapide</h4>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="departements/index.php" class="nav-link link-dark">
                            <i class="bi bi-building me-2"></i> Départements
                        </a>
                    </li>
                    <li>
                        <a href="formations/index.php" class="nav-link link-dark">
                            <i class="bi bi-mortarboard me-2"></i> Formations
                        </a>
                    </li>
                    <li>
                        <a href="professeurs/index.php" class="nav-link link-dark">
                            <i class="bi bi-person-badge me-2"></i> Professeurs
                        </a>
                    </li>
                    <li>
                        <a href="examens/index.php" class="nav-link link-dark">
                            <i class="bi bi-calendar-event me-2"></i> Examens
                        </a>
                    </li>
                    <li>
                        <a href="conflits/index.php" class="nav-link link-dark">
                            <i class="bi bi-exclamation-triangle me-2"></i> Conflits
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-9 main-content">
            <h2 class="mb-4">Dashboard</h2>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card stats-card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Départements</h6>
                                    <h2 class="mb-0"><?php echo $stats['departements']; ?></h2>
                                </div>
                                <i class="bi bi-building fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Étudiants</h6>
                                    <h2 class="mb-0"><?php echo $stats['etudiants']; ?></h2>
                                </div>
                                <i class="bi bi-people fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Examens à venir</h6>
                                    <h2 class="mb-0"><?php echo $stats['upcoming_exams']; ?></h2>
                                </div>
                                <i class="bi bi-calendar-check fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card bg-danger text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Conflits</h6>
                                    <h2 class="mb-0"><?php echo $stats['conflits']; ?></h2>
                                </div>
                                <i class="bi bi-exclamation-triangle fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Actions Rapides</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="examens/create.php" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Ajouter un Examen
                                </a>
                                <a href="sessions/create.php" class="btn btn-success">
                                    <i class="bi bi-calendar-plus"></i> Créer une Session
                                </a>
                                <a href="conflits/index.php" class="btn btn-warning">
                                    <i class="bi bi-exclamation-triangle"></i> Vérifier les Conflits
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Sessions Actives</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            $stmt = $pdo->query("SELECT * FROM sessions WHERE statut = 'EN_COURS' ORDER BY date_debut DESC LIMIT 5");
                            $sessions = $stmt->fetchAll();

                            if ($sessions) {
                                foreach ($sessions as $session) {
                                    echo '<div class="mb-2 p-2 border rounded">';
                                    echo '<strong>' . htmlspecialchars($session['nom']) . '</strong><br>';
                                    echo '<small class="text-muted">' . $session['date_debut'] . ' - ' . $session['date_fin'] . '</small>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p class="text-muted">Aucune session active</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Exams -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Examens Récents</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Module</th>
                                    <th>Date</th>
                                    <th>Salle</th>
                                    <th>Durée</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->query("
                                    SELECT e.*, m.nom as module_nom, l.nom as salle_nom 
                                    FROM examens e 
                                    JOIN modules m ON e.module_id = m.id 
                                    JOIN lieu_exam l ON e.salle_id = l.id 
                                    ORDER BY e.date_heure DESC 
                                    LIMIT 10
                                ");
                                $exams = $stmt->fetchAll();

                                foreach ($exams as $exam) {
                                    echo '<tr>';
                                    echo '<td>' . htmlspecialchars($exam['module_nom']) . '</td>';
                                    echo '<td>' . date('d/m/Y H:i', strtotime($exam['date_heure'])) . '</td>';
                                    echo '<td>' . htmlspecialchars($exam['salle_nom']) . '</td>';
                                    echo '<td>' . $exam['duree_minute'] . ' min</td>';
                                    echo '<td>';
                                    if (strtotime($exam['date_heure']) > time()) {
                                        echo '<span class="badge bg-warning">À venir</span>';
                                    } else {
                                        echo '<span class="badge bg-success">Terminé</span>';
                                    }
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>