<?php

require_once '../../app/config.php';
require_once '../../app/libraries/Database.class.php';

$id = $_GET['id'];
$time = $_GET['time'];

$conn = new Database();

$conn->cancelAppointment($id, $time);

header('Location: /appointments.php');