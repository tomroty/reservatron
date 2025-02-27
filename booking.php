<?php 
require 'header.php'; 
require 'functions/getAvailableSlots.php';
require_once 'functions/getReservedSlots.php';


$availableSlots = getAvailableSlots();
$reservedSlots = getReservedSlots();


$allSlots = [];
$startHour = 8;
$endHour = 18;

$date = new DateTime();
$date->setTime(0, 0, 0);

for ($d = 0; $d < 7; $d++) {
    $currentDate = clone $date;
    $dateStr = $currentDate->format('Y-m-d');
    
    for ($h = $startHour; $h <= $endHour; $h++) {
        $timeStr = sprintf("%02d:00", $h);
        $fullSlot = $dateStr . ' ' . $timeStr;
        
        if ($currentDate->setTime($h, 0) > new DateTime()) {
            $isReserved = in_array($fullSlot, $reservedSlots);
            $allSlots[$dateStr][] = [
                'time' => $timeStr,
                'full_slot' => $fullSlot,
                'reserved' => $isReserved
            ];
        }
    }
    
    $date->modify('+1 day');
}
?>

<div class="container mt-5">
    <h2 class="text-center">Prendre un Rendez-vous</h2>
    <?php if (isset($_SESSION["user_id"])): ?>
        <form action="functions/bookAppointment.php" method="post" class="mt-4">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
            <div class="mb-4">
                <?php foreach ($allSlots as $date => $times): ?>
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <?= (new DateTime($date))->format('d/m/Y') ?> 
                            (<?= (new DateTime($date))->format('l') ?>)
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($times as $timeData): ?>
                                    <div class="form-check">
                                        <?php if ($timeData['reserved']): ?>
                                            <input class="form-check-input" type="radio" 
                                                name="appointment_date" 
                                                id="slot-<?= $date.'-'.$timeData['time'] ?>" 
                                                value="<?= $timeData['full_slot'] ?>" 
                                                disabled>
                                            <label class="form-check-label text-muted slot-reserved" 
                                                for="slot-<?= $date.'-'.$timeData['time'] ?>">
                                                <?= $timeData['time'] ?>
                                            </label>
                                        <?php else: ?>
                                            <input class="form-check-input" type="radio" 
                                                name="appointment_date" 
                                                id="slot-<?= $date.'-'.$timeData['time'] ?>" 
                                                value="<?= $timeData['full_slot'] ?>">
                                            <label class="form-check-label" 
                                                for="slot-<?= $date.'-'.$timeData['time'] ?>">
                                                <?= $timeData['time'] ?>
                                            </label>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn btn-primary w-100">Réserver</button>
        </form>
    <?php else: ?>
        <p class="text-danger text-center">Vous devez être connecté pour prendre un rendez-vous.</p>
    <?php endif; ?>
</div>


<?php require 'footer.php'; ?>