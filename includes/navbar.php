<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="../pages/dashboard.php">
            <i class="bi bi-calendar-check"></i> Exam Planning
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../pages/dashboard.php">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-building"></i> Gestion
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../pages/departements/index.php">Départements</a></li>
                        <li><a class="dropdown-item" href="../pages/formations/index.php">Formations</a></li>
                        <li><a class="dropdown-item" href="../pages/professeurs/index.php">Professeurs</a></li>
                        <li><a class="dropdown-item" href="../pages/modules/index.php">Modules</a></li>
                        <li><a class="dropdown-item" href="../pages/etudiants/index.php">Étudiants</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-calendar-week"></i> Planning
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../pages/sessions/index.php">Sessions</a></li>
                        <li><a class="dropdown-item" href="../pages/examens/index.php">Examens</a></li>
                        <li><a class="dropdown-item" href="../pages/lieux/index.php">Salles</a></li>
                        <li><a class="dropdown-item" href="../pages/surveillances/index.php">Surveillances</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/conflits/index.php">
                        <i class="bi bi-exclamation-triangle"></i> Conflits
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> <?php echo $_SESSION['username'] ?? 'Utilisateur'; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="../logout.php">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>