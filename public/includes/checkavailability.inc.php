<?php

require_once '../../app/config.php';
require_once '../../app/libraries/Appointments.class.php';

$day = $_GET['querydate'];
$month = intval($_GET['querymonth']);
$year = $_GET['queryyear'];

$date = "$day/$month/$year";

$conn = new Appointments();

$dbResults = $conn->checkTimes($date);

$times = array_filter(TIMELIST, function ($t) {
    global $conn;
    global $dbResults;
    $chk = [];
    foreach($dbResults as $time) {
        if ($time->time == $t) {
            if (time() - $time->bookedTime > 900) {
                $conn->removeAppointment($time->id);
            } else {
                $chk[] = $t;
            }
        }
    }
    if (!empty($chk)) {
        return false;
    } else {
        return true;
    }
});

$result = json_encode($times);

print_r($result); // jquery approach