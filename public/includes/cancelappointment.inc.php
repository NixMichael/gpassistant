<?php

if (!isset($_GET['submit'])) {
    header('Location: /index.php');
    exit();
} else {
    if (!isset($_GET['id']) && !isset($_GET['time'])) {
        header('Location: /index.php');
        exit();
    }

    require_once '../../app/config.php';
    require_once '../../app/libraries/Appointments.class.php';

    $id = $_GET['id'];
    $time = $_GET['time'];

    $conn = new Appointments();

    $conn->cancelAppointment($id, $time);

    header('Location: /appointments.php');
     exit();
}