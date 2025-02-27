<?php require 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Prendre un Rendez-vous</h2>
    <?php if (isset($_SESSION["user_id"])): ?>
        <form action="functions/bookAppointment.php" method="post" class="mt-4">
            <div class="mb-3">
                <label for="appointment_date" class="form-label">Date et heure</label>
                <input type="datetime-local" name="appointment_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Réserver</button>
        </form>
    <?php else: ?>
        <p class="text-danger text-center">Vous devez être connecté pour prendre un rendez-vous.</p>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>
