<?php
require 'functions/db.php';

$error = null;
$success = false;

if (isset($_GET['token']) && isset($_GET['email'])) {
    $token = $_GET['token'];
    $email = $_GET['email'];
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email AND verification_token = :token AND active = 0");
    $stmt->execute([
        'email' => $email,
        'token' => $token
    ]);
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
        
        $updateStmt = $pdo->prepare("UPDATE users SET active = 1, verification_token = NULL WHERE id = :id");
        $updateStmt->execute(['id' => $user['id']]);
        
        $success = true;
    } else {
        $error = "Le lien de vérification est invalide ou a déjà été utilisé.";
    }
} else {
    $error = "Lien de vérification incomplet.";
}
?>

<?php require 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Vérification de votre compte</h2>
    
    <?php if ($success): ?>
        <div class="alert alert-success text-center">
            <h4>Félicitations!</h4>
            <p>Votre compte a été vérifié avec succès.</p>
            <p>Vous pouvez maintenant vous connecter.</p>
            <a href="login.php" class="btn btn-primary mt-2">Se connecter</a>
        </div>
    <?php else: ?>
        <div class="alert alert-danger text-center">
            <h4>Erreur</h4>
            <p><?php echo $error; ?></p>
            <a href="index.php" class="btn btn-primary mt-2">Retour à l'accueil</a>
        </div>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>