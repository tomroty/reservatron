<?php
require 'db.php';
session_start();

if (isset($_SESSION["user_id"])) {
    $stmt = $pdo->prepare("SELECT first_name, last_name, email FROM users WHERE id = :id");
    $stmt->execute(['id' => $_SESSION["user_id"]]);
    $user = $stmt->fetch();
}
?>
