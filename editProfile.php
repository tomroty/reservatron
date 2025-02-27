<?php 
require 'header.php'; 
require 'functions/getUserInfo.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$messages = [
    'success' => 'Vos informations ont été mises à jour avec succès.',
    'error' => 'Une erreur est survenue. Veuillez réessayer.',
    'email_exists' => 'Cette adresse email est déjà utilisée.'
];
?>

<div class="container mt-5">
    <h2 class="text-center">Modifier mon Profil</h2>
    
    <?php if (isset($_GET['status']) && isset($messages[$_GET['status']])): ?>
        <div class="alert alert-<?= $_GET['status'] === 'success' ? 'success' : 'danger' ?>">
            <?= $messages[$_GET['status']] ?>
        </div>
    <?php endif; ?>
    
    <form action="functions/updateProfile.php" method="post" class="mt-4">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); ?>">
        
        <div class="mb-3">
            <label for="first_name" class="form-label">Prénom</label>
            <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($user['first_name']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="last_name" class="form-label">Nom</label>
            <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($user['last_name']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="birth_date" class="form-label">Date de naissance</label>
            <input type="date" name="birth_date" class="form-control" value="<?= $user['birth_date'] !== 'Non renseigné' ? htmlspecialchars($user['birth_date']) : ''; ?>">
        </div>
        
        <div class="mb-3">
            <label for="address" class="form-label">Adresse</label>
            <textarea name="address" class="form-control"><?= $user['address'] !== 'Non renseigné' ? htmlspecialchars($user['address']) : ''; ?></textarea>
        </div>
        
        <div class="mb-3">
            <label for="phone" class="form-label">Téléphone</label>
            <input type="tel" name="phone" class="form-control" pattern="[0-9]{10}" value="<?= $user['phone'] !== 'Non renseigné' ? htmlspecialchars($user['phone']) : ''; ?>">
            <small class="text-muted">Format: 0612345678</small>
        </div>
        
        <div class="mb-3">
            <label for="new_password" class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
            <input type="password" name="new_password" class="form-control">
        </div>
        
        <div class="mb-3">
            <label for="current_password" class="form-label">Mot de passe actuel (requis pour confirmer les changements)</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>
        
        <div class="d-flex justify-content-between">
            <a href="profile.php" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </div>
    </form>
</div>

<?php require 'footer.php'; ?>