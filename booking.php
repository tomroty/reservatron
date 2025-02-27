<?php 
require 'header.php'; 
require 'functions/getAvailableSlots.php';
$availableSlots = getAvailableSlots();
?>

<div class="container mt-5">
    <h2 class="text-center">Prendre un Rendez-vous</h2>
    <?php if (isset($_SESSION["user_id"])): ?>
        <form action="functions/bookAppointment.php" method="post" class="mt-4">
            <div class="list-group mb-3">
                <?php foreach ($availableSlots as $slot): ?>
                    <label class="list-group-item">
                        <input type="radio" name="appointment_date" value="<?= $slot ?>" class="me-2" required>
                        <?= (new DateTime($slot))->format('d/m/Y H:i') ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn btn-primary w-100">Réserver</button>
        </form>
    <?php else: ?>
        <p class="text-danger text-center">Vous devez être connecté pour prendre un rendez-vous.</p>
    <?php endif; ?>
</div>

<?php require 'footer.php'; ?>
