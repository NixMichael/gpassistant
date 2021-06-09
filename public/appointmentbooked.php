<?php

$confirmation = $_GET['status'];

$result = $confirmation == 'success' ? 'Thank you. You successfully booked an appointment' : 'Booking error. Please try again.';

require_once 'includes/header.inc.php';
?>

<div class="container">
    <?php if ($confirmation) : ?>
        <div class="alert"><?php echo $result ?></div>
    <?php endif ?>
</div>

<?php require_once 'includes/footer.inc.php'; ?>