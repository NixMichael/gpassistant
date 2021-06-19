<?php if (!defined('APP_RUN')) die(header('Location: /')) ?>

<?php
    $unconfirmed = [];
    $confirmed = [];
    foreach($appointments as $appt) {
        if ($appt['accepted'] != true) {
            $unconfirmed[] = $appt;
        } else {
            $confirmed[] = $appt;
        }
    }
?>

<form class="doctor-appointments" action="includes/confirmappointment.inc.php" method="POST">
    <ul>
        <h3>Unconfirmed Appointments:</h3>
        <li><span>Date</span><span>Time</span><span>Patient Number</span><span>Confirm Appointment</span></li>
        <?php if (empty($unconfirmed)) : ?>
            <div class='no-appointments'>No unconfirmed appointments to display</div>
        <?php else : ?>
        <?php foreach($unconfirmed as $appt) : ?>
            <li class='<?php echo $appt['accepted'] != true ? 'unconfirmed' : '' ?>'><div><span><?php echo $appt['date']?></span><span><?php echo $appt['time']?></span><span><?php echo $appt['patient_id']?></span><span><button type='submit' name='apptid' value='<?php echo $appt['id'] ?>'>Confirm</button></span></div><div><span class='appointment-notes'>Message: <?php echo $appt['message']?></span></div></li>
        <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</form>

<ul class="doctor-appointments">
    <h3>Confirmed Appointments:</h3>
    <li><span>Date</span><span>Time</span><span>Patient Number</span><span></span></li>
    <?php if (empty($confirmed)) : ?>
        <div class='no-appointments'>No confirmed appointments to display</div>
    <?php else: ?>
    <?php foreach($appointments as $appt) : ?>
        <li class='<?php echo $appt['accepted'] != true ? 'unconfirmed' : '' ?>'><div><span><?php echo $appt['date']?></span><span><?php echo $appt['time']?></span><span><?php echo $appt['patient_id']?></span><span></span></div><div><span class='appointment-notes'>Message: <?php echo $appt['message']?></span></div></li>
    <?php endforeach; ?>
    <?php endif; ?>
</ul>