<?php require 'header.php'; require 'functions/getUserInfo.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Mon Profil</h2>
    <?php if (isset($user)): ?>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($user['first_name']); ?></p>
        <p><strong>Nom :</strong> <?= htmlspecialchars($user['last_name']); ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($user['email']); ?></p>
        
        <div class="mt-4">
            <form action="functions/deleteAccount.php" method="POST">
                <button type="submit" class="btn btn-danger">Supprimer mon compte</button>
            </form>
        </div>
    <?php else: ?>
        <p class="text-danger text-center">Vous devez être connecté pour voir votre profil.</p>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>
