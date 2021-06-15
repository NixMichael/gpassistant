<?php if (!defined('APP_RUN')) die(header('Location: /')) ?>

<?php if (!$_GET['month']) : ?>
<div class="current-appointments">
    <?php if (!$appointments) : ?>
        <div>No upcoming appointments.</div>
        <!-- <div class='button' onclick="showBooking()">Make an appointment</div> -->
        <a class='button' href="?month=<?php echo $month ?>">Make an appointment</a>
    <?php else : ?>
        <div>Upcoming appointments:</div>
        <div class='booked-appointment'><span><?php echo "Date: ".$appointments[0]['day'] ?></span><span><?php echo "Time: ".$appointments[0]['time'] ?></span><span>Doctor: <?php echo $appointments[0]['doctor_id'] ?: 'Unassigned' ?></span></div>
        <div class='booked-appointment appointment-note'><strong>Message to doctor:&emsp;</strong><?php echo $appointments[0]['notes'] ?: 'None provided' ?></div>
        <a class="button" href="includes/cancelappointment.inc.php?id=<?php echo $appointments[0]['id'] ?>&time=<?php echo $appointments[0]['time'] ?>">Cancel Appointment</a>
    <?php endif; ?>
</div>
<?php else : ?>
    <div class='container appointments-container'>
    <div class='calendar-area'>
        <div id='choose-date'>
            <?php echo buildCalendar($month, $year); ?>
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