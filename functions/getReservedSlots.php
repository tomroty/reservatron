<?php
require_once 'db.php';

function getReservedSlots() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT appointment_date FROM appointments WHERE status != 'cancelled'");
    $stmt->execute();
    $slots = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $formattedSlots = [];
    foreach ($slots as $slot) {
        $dateTime = new DateTime($slot);
        $formattedSlots[] = $dateTime->format('Y-m-d H:i');
    }
    
    return $formattedSlots;
}