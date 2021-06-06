<?php
$date = $_GET['day'];
$month = $_GET['month'];

$times = ['08:30', '09:10', '09:40', '10:20', '11:00', '11:40'];

// Query database for unavailable times

// header("Location: /appointments.php?date=$date&month=$month&times=$times");