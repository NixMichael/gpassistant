<?php

session_start();

require_once '../../app/config.php';
require_once '../../app/libraries/Appointments.class.php';

$_SESSION['apptid'] = NULL;

if (time() - $_SESSION['booking-start-time'] < 900) {

    $conn = new Appointments();
    if (isset($_POST['submit'])) {
        $appt_id = $_POST['appt_id'];
        $message = $_POST['message'];

        $result = $conn->addAppointmentNote($appt_id, $_SESSION['patientid'], $message, 'P');

        $status = $result ? 'success' : 'fail';

        header('Location: /appointmentbooked.php?status=success');
        exit();
    } else if (isset($_POST['cancel'])) {
        $appt_id = $_POST['appt_id'];
        $conn->removeAppointment($appt_id, $_SESSION['patientid']);
        header('Location: /appointments.php');
        exit();
    } else {
        header('Location: /index.php');
        exit();
    }
} else {
    header('Location: /appointments.php?error=timeout');
    exit();
}