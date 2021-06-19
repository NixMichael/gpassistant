<?php

session_start();

if (empty($_SESSION['patientid'])) {
    header('Location: /');
}

require_once 'includes/header.inc.php';

require_once '../app/config.php';
require_once '../app/libraries/Appointments.class.php';

if (!isset($_POST['time'])) {
    header('Location: /index.php');
    exit();
} else {
    $time = $_POST['time'];
    $day = $_POST['date'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $ptId = $_SESSION['patientid'];

    $conn = new Appointments();

    $date = "$day/$month/$year";
    $currentTime = time();

    if ((!isset($_SESSION['apptid']) || $_SESSION['apptid'] != true)) {
        $_SESSION['apptid'] = $conn->addAppointment($date, $time, $ptId);
        $_SESSION['booking-start-time'] = time();
    }
}

?>

<div class="container">
    <div class="confirm-appointment">
        <h3 id="complete-booking-header">Complete appointment booking <span id="booking-timer-text">(expires in <span id="complete-booking-timer"></span> minutes)</span></h3>
        <div id="booking-details"><?php echo "<div>Date: ".$day."/".$month."/".$year."</div><div>Time: ".$time."</div>"; ?></div>
        <form id="frm" action="/includes/confirmbooking.inc.php" method="POST">
            <textarea name="message" placeholder="Leave a message for the doctor about your reason for booking an appointment (max 500 characters)" maxlength="500"></textarea>
            <input type="hidden" name="appt_id" value="<?php echo $_SESSION['apptid'] ?>">
            <input type="hidden" name="time" value="<?php echo $time ?>">
            <input type="hidden" name="date" value="<?php echo $day ?>">
            <button id="submit-form" type="submit" name="submit">Confirm Appointment</button>
            <button id="cancel" type="submit" name="cancel">Cancel</button>
        </form>
    </div>

</div>

<script>
    const title = document.getElementById("complete-booking-header");
    const timerText = document.getElementById("booking-timer-text");
    const timerDisplay = document.getElementById("complete-booking-timer");
    const confirmButton = document.getElementById("submit-form");
    const cancel = document.getElementById("cancel");

    let timeNow = Date.now() / 1000; // Get timestamp in seconds

    // Check for existing timer_value from sessionStorage. Create if does not exist.

    let counter = sessionStorage.getItem('timer_value');
    if (!counter) {
        counter = Date.now() / 1000;
        sessionStorage.setItem('timer_value', counter);
    }

    let difference = Math.ceil(timeNow - counter);

    // Get time remaining in seconds. Begin 1000ms interval loop, convert
    // 'seconds remaining' to minutes, and check when seconds remaining reaches 0

    let c = 900 - difference;
    let timer = setInterval(() => {
        let mins = Math.ceil(c / 60);
        timerDisplay.textContent = mins;
        c--;
        if (c < 60) {
            timerText.style.color = 'red';
        }
        if (c <= 0) {
            title.textContent = "This booking has now expired. Please start again.";
            confirmButton.style.opacity = '0.5';
            confirmButton.disabled = true;
            cancel.textContent = 'Restart';
            clearInterval(timer);
        }
    }, 1000)

</script>

<?php require_once 'includes/footer.inc.php'; ?>