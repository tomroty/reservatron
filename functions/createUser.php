<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    if (!empty($first_name) && !empty($last_name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($_POST["password"])) {
        $check_email = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $check_email->execute(['email' => $email]);
        
        if ($check_email->rowCount() > 0) {
            header("Location: ../register.php?error=email_exists");
            exit();
        }

        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password) 
                               VALUES (:first_name, :last_name, :email, :password)");
        $stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $password
        ]);
        
        header("Location: ../login.php?register=success");
        exit();
    }
    
    header("Location: ../register.php?error=invalid_input");
    exit();
}
?>