<?php
require 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
    $appointment_date = $_POST["appointment_date"];

    if (!empty($appointment_date)) {
        $stmt = $pdo->prepare("INSERT INTO appointments (user_id, appointment_date, status) VALUES (:user_id, :appointment_date, 'confirmed')");
        $stmt->execute([
            'user_id' => $_SESSION["user_id"],
            'appointment_date' => $appointment_date
        ]);
        header("Location: ../appointments.php");
        exit();
    }
}
?>
