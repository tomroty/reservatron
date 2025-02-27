<?php
require 'db.php';
session_start();

if (isset($_SESSION["user_id"])) {
    $stmt = $pdo->prepare("SELECT first_name, last_name, email, 
                          IFNULL(birth_date, 'Non renseigné') as birth_date, 
                          IFNULL(address, 'Non renseigné') as address, 
                          IFNULL(phone, 'Non renseigné') as phone, 
                          IFNULL(active, 0) as active,
                          created_at 
                          FROM users WHERE id = :id");
    $stmt->execute(['id' => $_SESSION["user_id"]]);
    $user = $stmt->fetch();
}
?>