<?php

require_once '../../app/config.php';
require_once '../../app/libraries/Database.class.php';

if (isset($_POST['submit'])) {
    $time = $_POST['time'];
    $date = $_POST['date'];
    $note = $_POST['note'];

    $conn = new Database();

    $result = $conn->addAppointment($date, $time, $note);

    $status = $result ? 'success' : 'fail';

    header('Location: /appointmentbooked.php?status=success');
} else if (isset($_POST['cancel'])) {
    header('Location: /makeCalendar.php');
}