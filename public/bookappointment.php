<?php

session_start();

if (empty($_SESSION['useremail'])) {
    header('Location: /');
}

require_once 'includes/header.inc.php';

require_once '../app/config.php';
require_once '../app/libraries/Database.class.php';

$time = $_POST['time'];
$date = $_POST['date'];
$month = $_POST['month'];
$year = $_POST['year'];

$conn = new Database();

$result = $conn->addAppointment($date, $time);

?>

<div class="container appointments-container">
    <div class="confirm-appointment">
        <h3>Finalise appointment booking</h3>
        <?php echo "<div>Date: ".$date."/".$month."/".$year."</div><div>Time: ".$time."</div>"; ?>
        <form id="frm" action="/includes/confirmbooking.inc.php" method="POST">
            <textarea name="note" placeholder="Leave a message for the doctor about your reason for booking an appointment (max 500 characters)" maxlength="500"></textarea>
            <input type="hidden" name="time" value="<?php echo $time ?>">
            <input type="hidden" name="date" value="<?php echo $date ?>">
            <button type="submit" name="submit">Confirm Appointment</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
    </div>

</div>

<?php require_once 'includes/footer.inc.php'; ?>