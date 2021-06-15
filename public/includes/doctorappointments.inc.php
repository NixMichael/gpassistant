<?php if (!defined('APP_RUN')) die(header('Location: /')) ?>

<form class="doctor-appointments" action="includes/confirmappointment.inc.php" method="POST">
    <ul>
        <h4>Unconfirmed Appointments:</h4>
        <li><span>Date</span><span>Time</span><span>Patient Number</span><span>Confirm Appointment</span></li>
        <?php foreach($appointments as $appt) : ?>
            <?php if ($appt['accepted'] != true) : ?>
                <li class='<?php echo $appt['accepted'] != true ? 'unconfirmed' : '' ?>'><div><span><?php echo $appt['day']?></span><span><?php echo $appt['time']?></span><span><?php echo $appt['username']?></span><span><button type='submit' name='apptid' value='<?php echo $appt['id'] ?>'>Confirm</button></span></div><div><span class='appointment-notes'>Notes: <?php echo $appt['id']?></span></div></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</form>

    <ul class="doctor-appointments">
        <h4>Confirmed Appointments:</h4>
        <li><span>Date</span><span>Time</span><span>Patient Number</span><span></span></li>
        <?php foreach($appointments as $appt) : ?>
        <?php if ($appt['accepted'] != false) : ?>
            <li class='<?php echo $appt['accepted'] != true ? 'unconfirmed' : '' ?>'><div><span><?php echo $appt['day']?></span><span><?php echo $appt['time']?></span><span><?php echo $appt['username']?></span><span></span></div><div><span class='appointment-notes'>Notes: <?php echo $appt['notes']?></span></div></li>
        <?php endif; ?>
        <?php endforeach; ?>
    </ul>