<?php
require 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT id, first_name, last_name, password FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["first_name"] . " " . $user["last_name"];
            header("Location: ../profile.php");
            exit();
        }
    }
    header("Location: ../login.php?error=invalid");
    exit();
}
?>