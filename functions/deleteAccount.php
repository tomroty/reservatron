<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php?error=not_logged_in");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    
    session_unset();
    session_destroy();

    header("Location: ../index.php?account=deleted");
    exit();

} catch (PDOException $e) {
    header("Location: ../profile.php?error=delete_failed");
    exit();
}
?>
