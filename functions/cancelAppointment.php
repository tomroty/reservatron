<?php
require 'db.php';
session_start();

if (isset($_SESSION["user_id"]) && isset($_GET["id"])) {
    $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = :id AND user_id = :user_id");
    $stmt->execute([
        'id' => $_GET["id"],
        'user_id' => $_SESSION["user_id"]
    ]);
}

header("Location: ../appointments.php");
exit();
?>
