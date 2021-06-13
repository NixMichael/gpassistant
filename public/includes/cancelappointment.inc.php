<?php

require_once '../../app/config.php';
require_once '../../app/libraries/Appointments.class.php';

$id = $_GET['id'];
$time = $_GET['time'];

$conn = new Appointments();

$conn->cancelAppointment($id, $time);

header('Location: /appointments.php');