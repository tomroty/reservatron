<?php require 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Contact</h2>
    
    <form method="post" class="mt-4">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); ?>">
        
        <div class="mb-3">
            <label for="name" class="form-label">Nom complet</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="subject" class="form-label">Sujet</label>
            <input type="text" name="subject" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Envoyer</button>
    </form>
</div>

<?php require 'footer.php'; ?>