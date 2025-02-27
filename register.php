<?php require 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Inscription</h2>
    <?php if (isset($_GET['error'])): ?>
        <?php if ($_GET['error'] == 'email_exists'): ?>
            <div class="alert alert-danger">
                Cette adresse email est déjà utilisée. Veuillez en choisir une autre.
            </div>
        <?php elseif ($_GET['error'] == 'invalid_input'): ?>
            <div class="alert alert-danger">
                Veuillez remplir tous les champs correctement.
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <form action="functions/createUser.php" method="post" class="mt-4">
        <div class="mb-3">
            <label for="first_name" class="form-label">Prénom</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Nom</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">S'inscrire</button>
    </form>
</div>

<?php require 'footer.php'; ?>