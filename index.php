<?php require 'header.php'; require 'functions/getUserInfo.php';?>

<div class="container text-center mt-5">

    <?php if (isset($user)): ?>
        <h1 class="text-center">Bienvenue sur Réservatron, <?= htmlspecialchars($user['first_name']); ?></h1>
    <?php else: ?>
        <h1>Bienvenue sur Réservatron</h1>
    <?php endif; ?>
    
    <p class="mt-3">Prenez et gérez vos rendez-vous en ligne facilement.</p>
    <?php if (!isset($_SESSION["user_id"])): ?>
        <a href="login.php" class="btn btn-primary">Se connecter</a>
        <a href="register.php" class="btn btn-secondary">S'inscrire</a>
    <?php else: ?>
        <a href="appointments.php" class="btn btn-primary">Voir mes rendez-vous</a>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>
