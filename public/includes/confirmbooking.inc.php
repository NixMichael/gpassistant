<?php

session_start();

require_once '../../app/config.php';
require_once '../../app/libraries/Appointments.class.php';

$conn = new Appointments();
if (isset($_POST['submit'])) {
    $appt_id = $_POST['appt_id'];
    // $time = $_POST['time'];
    // $date = $_POST['date'];
    $message = $_POST['message'];
    
    $result = $conn->addAppointmentNote($appt_id, $message, $_SESSION['patientid'], 'P');

    $status = $result ? 'success' : 'fail';

    header('Location: /appointmentbooked.php?status=success');
} else if (isset($_POST['cancel'])) {
    $time = $_POST['time'];
    $date = $_POST['date'];
    $conn->removeAppointment($date, $time);
    header('Location: /appointments.php');
}