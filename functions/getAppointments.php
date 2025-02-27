<?php
require 'db.php';
session_start();

$appointments = [];

if (isset($_SESSION["user_id"])) {
    $stmt = $pdo->prepare("SELECT id, appointment_date FROM appointments WHERE user_id = :user_id ORDER BY appointment_date ASC");
    $stmt->execute(['user_id' => $_SESSION["user_id"]]);
    $appointments = $stmt->fetchAll();
}
?>
