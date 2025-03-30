<?php
require 'db.php';
session_start();

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header("Location: ../register.php?error=invalid_token");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $birth_date = trim($_POST["birth_date"]);
    $address = trim($_POST["address"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $verification_token = bin2hex(random_bytes(16));
    $active = 1;


    if (!empty($first_name) && 
        !empty($last_name) && 
        !empty($birth_date) && 
        !empty($address) && 
        preg_match('/^[0-9]{10}$/', $phone) && 
        filter_var($email, FILTER_VALIDATE_EMAIL) && 
        !empty($_POST["password"])) {
        
        $check_email = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $check_email->execute(['email' => $email]);
        
        if ($check_email->rowCount() > 0) {
            header("Location: ../register.php?error=email_exists");
            exit();
        }

        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, birth_date, address, phone, email, password, verification_token, active) 
                              VALUES (:first_name, :last_name, :birth_date, :address, :phone, :email, :password, :verification_token, :active)");
        $result = $stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'birth_date' => $birth_date,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'password' => $password,
            'verification_token' => $verification_token,
            'active' => $active
        ]);
        
        if ($result) {
            header("Location: ../login.php?register=success");
            exit();
        }
    }
    
    header("Location: ../register.php?error=invalid_input");
    exit();
}
?>