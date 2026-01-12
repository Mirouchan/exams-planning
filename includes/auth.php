<?php
session_start();
require_once __DIR__ . '/../config/database.php';

/**
 * Ensure the user is logged in
 */
function requireLogin(): void
{
    if (!isset($_SESSION['user'])) {
        header('Location: /exams-planning/login.php');
        exit;
    }
}

/**
 * Login function
 */
function login(string $id, ?string $fullname = null): bool
{
    global $pdo;

    // ---------- ADMIN ----------
    if ($id === 'admin' && $fullname === 'admin') {
        $_SESSION['user'] = [
            'id' => 'admin',
            'name' => 'Administrator',
            'role' => 'admin'
        ];
        return true;
    }

    // ---------- PROFESSOR ----------
    $sql = "SELECT * FROM professeurs
            WHERE id = :id
            AND LOWER(TRIM(CONCAT(nom, ' ', prenom))) = LOWER(TRIM(:fullname))
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $id,
        ':fullname' => $fullname
    ]);

    $prof = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($prof) {
        $_SESSION['user'] = [
            'id' => $prof['id'],
            'name' => $prof['nom'] . ' ' . $prof['prenom'],
            'role' => 'prof'
        ];
        return true;
    }

    // ---------- STUDENT ----------
    $sql = "SELECT * FROM etudiants
            WHERE id = :id
            AND LOWER(TRIM(CONCAT(nom, ' ', prenom))) = LOWER(TRIM(:fullname))
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $id,
        ':fullname' => $fullname
    ]);

    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
        $_SESSION['user'] = [
            'id' => $student['id'],
            'name' => $student['nom'] . ' ' . $student['prenom'],
            'role' => 'student'
        ];
        return true;
    }

    return false;
}

/**
 * Logout
 */
function logout(): void
{
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
    header('Location: /exams-planning/login.php');
    exit;
}

/**
 * Role helpers
 */
function isAdmin(): bool
{
    return ($_SESSION['user']['role'] ?? '') === 'admin';
}

function isProf(): bool
{
    return ($_SESSION['user']['role'] ?? '') === 'prof';
}

function isStudent(): bool
{
    return ($_SESSION['user']['role'] ?? '') === 'student';
}
