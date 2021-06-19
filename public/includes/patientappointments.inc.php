<?php if (!defined('APP_RUN')) die(header('Location: /')) ?>

<?php if (!$_GET['month']) : ?>
<div class="current-appointments">
    <?php if (!$appointments) : ?>
        <div>No upcoming appointments.</div>
        <!-- <div class='button' onclick="showBooking()">Make an appointment</div> -->
        <a class='button' href="?month=<?php echo $month ?>">Make an appointment</a>
    <?php else : ?>
        <div>Upcoming appointments:</div>
        <div class='booked-appointment'><span><?php echo "Date: ".$appointments['date'] ?></span><span><?php echo "Time: ".$appointments['time'] ?></span><span>Doctor: <?php echo $appointments['doctor_id'] ?: 'Unassigned' ?></span></div>
        <div class='booked-appointment appointment-note'><strong>Issue:&emsp;</strong><span><?php echo $appointments['message'] ?: 'None provided' ?></span></div>
        <form action="includes/cancelappointment.inc.php" method="GET"> <input type="hidden" name="id" value="<?php echo $appointments['id'] ?>"><input type="hidden" name="time" value="<?php echo $appointments['time'] ?>"><input class="button" type="submit" name="submit" value="Cancel Appointment"/></form>
    <?php endif; ?>
</div>
<?php else : ?>
    <div class='container appointments-container'>
    <div class='calendar-area'>
        <div id='choose-date'>

            <div><h2>1. Choose a date</h2><div>
                <div class='calendar-heading'>
                    <?php echo buildCalendar($month, $year); ?>
                </div>
            </div>
        </div>
        <div id='choose-time'>
            <div><h2>2. Choose a time</h2></div>
            <form action="/bookappointment.php" method="POST" class="results">
                <div class="times-heading"></div>
                <div class="results-area"></div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>