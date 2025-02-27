<?php
require_once 'db.php';

function getReservedSlots() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT appointment_date FROM appointments WHERE status != 'cancelled'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
