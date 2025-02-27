<?php require 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Connexion</h2>
    <?php if (isset($_GET['register']) && $_GET['register'] == 'success'): ?>
        <div class="alert alert-success">
            Inscription réussie ! Vous pouvez maintenant vous connecter.
        </div>
    <?php endif; ?>
    <form action="functions/login.php" method="post" class="mt-4">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
    </form>
</div>

<?php require 'footer.php'; ?>