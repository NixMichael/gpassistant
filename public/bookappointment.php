<?php

session_start();

if (empty($_SESSION['useremail'])) {
    header('Location: /');
}

require_once 'includes/header.inc.php';

require_once '../app/config.php';
require_once '../app/libraries/Appointments.class.php';

$time = $_POST['time'];
$day = $_POST['date'];
$month = $_POST['month'];
$year = $_POST['year'];

$conn = new Appointments();

$date = "$day/$month/$year";
$currentTime = time();

$apptId = $conn->addAppointment($date, $time, $currentTime);
?>

<div class="container">
    <div class="confirm-appointment">
        <h3>Finalise appointment booking</h3>
        <?php echo "<div>Date: ".$day."/".$month."/".$year."</div><div>Time: ".$time."</div>"; ?>
        <form id="frm" action="/includes/confirmbooking.inc.php" method="POST">
            <textarea name="message" placeholder="Leave a message for the doctor about your reason for booking an appointment (max 500 characters)" maxlength="500"></textarea>
            <input type="hidden" name="appt_id" value="<?php echo $apptId ?>">
            <input type="hidden" name="time" value="<?php echo $time ?>">
            <input type="hidden" name="date" value="<?php echo $day ?>">
            <button type="submit" name="submit">Confirm Appointment</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
    </div>

</div>

<script>
    $(window).on('beforeunload', function(){
        const c=confirm();
        if(c){
            return true;
        } else {
            return false;
        });
</script>

<?php require_once 'includes/footer.inc.php'; ?>