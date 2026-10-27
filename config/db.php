<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$db_host = getenv('DB_HOST') ?: '127.0.0.1';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
$db_name = getenv('DB_NAME') ?: 'handy_hands';
try {
    $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage() . "<br>Please ensure MySQL is running in XAMPP and `database/handy_hands.sql` is imported.");
}
function isLoggedIn() { return isset($_SESSION['user_id']); }
function requireRole($role) {
    if (!isLoggedIn() || $_SESSION['user_role'] !== $role) {
        header("Location: ../auth/login.php?error=unauthorized");
        exit;
    }
}
?>