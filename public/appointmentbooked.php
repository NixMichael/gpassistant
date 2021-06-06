<?php

$confirmation = $_GET['booked'];

$result = $confirmation == 1 ? 'Booking successful' : 'Booking error';

require_once 'includes/header.inc.php';
?>

<div class="container">
    <?php if ($confirmation) : ?>
        <div class="alert"><?php echo $result ?></div>
    <?php endif ?>
</div>

<?php require_once 'includes/footer.inc.php'; ?>