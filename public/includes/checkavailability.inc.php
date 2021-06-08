<?php

require_once '../../app/config.php';
require_once '../../app/libraries/Database.class.php';

$day = $_GET['queryday'];
$month = $_GET['querymonth'];
$year = $_GET['queryyear'];


$conn = new Database();

$response = $conn->checkTimes($day);

// $result = ['9:30', '10:00', '1:45', '2:30', '3:30', '3:45', '4:00', '4:45', '5:15'];
// $result = json_encode($times);
// print_r($times);

$times = [];
foreach($response as $time) {
    $times[] = $time['time'];
}

// print_r($b);

$result = json_encode($times);


header("Location: /makeCalendar.php?result=$result");