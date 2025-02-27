<?php
require 'db.php';
require '../vendor/autoload.php';
session_start();

// Vérification CSRF
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
    $active = 0; 


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
            try {
                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.example.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'your-email@example.com'; 
                $mail->Password = 'your-password'; 
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                
                $mail->setFrom('no-reply@reservatron.com', 'Réservatron');
                $mail->addAddress($email, $first_name . ' ' . $last_name);
                $mail->isHTML(true);
                $mail->Subject = 'Vérification de votre compte Réservatron';
                $mail->Body = "Bonjour $first_name $last_name,<br><br>
                            Merci pour votre inscription sur Réservatron. Veuillez cliquer sur le lien ci-dessous pour activer votre compte:<br><br>
                            <a href='http://votre-site.com/verify.php?token=$verification_token&email=$email'>Activer mon compte</a><br><br>
                            Cordialement,<br>
                            L'équipe Réservatron";
                
                $mail->send();
                
                header("Location: ../login.php?register=pending&email=" . urlencode($email));
                exit();
            } catch (Exception $e) {
                header("Location: ../login.php?register=success&email_error=true");
                exit();
            }
        }
    }
    
    header("Location: ../register.php?error=invalid_input");
    exit();
}
?>