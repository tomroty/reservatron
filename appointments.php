<?php require 'header.php'; require 'functions/getAppointments.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Mes Rendez-vous</h2>
    <?php if (isset($_SESSION["user_id"])): ?>
        <div class="text-center mb-4">
            <a href="booking.php" class="btn btn-primary">Prendre un rendez-vous</a>
        </div>
        <?php if (!empty($appointments)): ?>
            <ul class="list-group mt-4">
                <?php foreach ($appointments as $appointment): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <?= htmlspecialchars($appointment["appointment_date"]); ?>
                        <a href="functions/cancelAppointment.php?id=<?= $appointment["id"]; ?>" class="btn btn-danger btn-sm">Annuler</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-center">Aucun rendez-vous pris.</p>
        <?php endif; ?>
    <?php else: ?>
        <p class="text-danger text-center">Vous devez être connecté pour voir vos rendez-vous.</p>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>
