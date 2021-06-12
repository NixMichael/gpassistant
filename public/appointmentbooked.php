<?php

$confirmation = $_GET['status'];

$result = $confirmation == 'success' ? 'Thank you. You successfully booked an appointment.' : 'Booking error. Please try again.';

require_once 'includes/header.inc.php';
?>

<div class="container">
    <?php if ($confirmation) : ?>
        <div class="alert">
        <h4><?php echo $result ?></h4>
        <a class="button" href="/appointments.php">Return to your appointments</a>
    </div>
    <?php endif ?>
</div>

<?php require_once 'includes/footer.inc.php'; ?>