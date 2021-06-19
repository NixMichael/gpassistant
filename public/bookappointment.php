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
        <h3 id="complete-booking-header">Complete appointment booking <span>(expires in <span id="complete-booking-timer"></span> minutes)</span></h3>
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
    const timerDisplay = document.getElementById("complete-booking-timer");
    const confirmButton = document.getElementById("submit-form");
    const cancel = document.getElementById("cancel");

    let timeNow = Date.now() / 1000;

    let counter = sessionStorage.getItem('timer_value');
    console.log(counter);
    // console.log(`from storage: ${counter} | now: ${Date.now()} | difference: ${Date.now() - counter}`);
    if (!counter) {
        counter = Date.now() / 1000;
        sessionStorage.setItem('timer_value', counter);
    }

    let difference = Math.ceil(timeNow - counter);
    console.log(`Difference: ${difference}`);

    let c = 900 - difference;
    let timer = setInterval(() => {
        let mins = Math.ceil(c / 60);
        timerDisplay.textContent = mins;
        c--;
        console.log(c);
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