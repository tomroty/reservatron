<?php
require 'db.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header("Location: ../editProfile.php?status=error");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $birth_date = !empty($_POST["birth_date"]) ? trim($_POST["birth_date"]) : null;
    $address = !empty($_POST["address"]) ? trim($_POST["address"]) : null;
    $phone = !empty($_POST["phone"]) ? trim($_POST["phone"]) : null;
    $new_password = $_POST["new_password"];
    $current_password = $_POST["current_password"];
    
    $check_password = $pdo->prepare("SELECT password FROM users WHERE id = :id");
    $check_password->execute(['id' => $user_id]);
    $user_data = $check_password->fetch();
    
    if (!$user_data || !password_verify($current_password, $user_data["password"])) {
        header("Location: ../editProfile.php?status=error");
        exit();
    }
    
    if (!empty($email)) {
        $check_email = $pdo->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
        $check_email->execute(['email' => $email, 'id' => $user_id]);
        
        if ($check_email->rowCount() > 0) {
            header("Location: ../editProfile.php?status=email_exists");
            exit();
        }
    }
    
    $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email";
    $params = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'id' => $user_id
    ];
    
    if ($birth_date !== null) {
        $sql .= ", birth_date = :birth_date";
        $params['birth_date'] = $birth_date;
    }
    
    if ($address !== null) {
        $sql .= ", address = :address";
        $params['address'] = $address;
    }
    
    if ($phone !== null) {
        $sql .= ", phone = :phone";
        $params['phone'] = $phone;
    }
    
    if (!empty($new_password)) {
        $sql .= ", password = :password";
        $params['password'] = password_hash($new_password, PASSWORD_DEFAULT);
    }
    
    $sql .= " WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute($params);
    
    if ($result) {
        header("Location: ../editProfile.php?status=success");
        exit();
    } else {
        header("Location: ../editProfile.php?status=error");
        exit();
    }
}

header("Location: ../editProfile.php");
exit();
?>