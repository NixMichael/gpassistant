<?php

require_once '../../app/config.php';
require_once '../../app/libraries/Database.class.php';

$conn = new Database();
if (isset($_POST['submit'])) {
    $time = $_POST['time'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    
    $result = $conn->addAppointmentNote($date, $time, $note);
    
    $status = $result ? 'success' : 'fail';

    header('Location: /appointmentbooked.php?status=success');
} else if (isset($_POST['cancel'])) {
    $time = $_POST['time'];
    $date = $_POST['date'];
    $conn->removeAppointment($date, $time);
    header('Location: /appointments.php');
}