<?php

require_once 'includes/header.inc.php';
require_once '../app/config.php';
require_once '../app/libraries/Appointments.class.php';

define('APP_RUN', true);

session_start();

if (empty($_SESSION['useremail'])) {
    header('Location: /');
}

$conn = new Appointments();

$patientid = $_SESSION['patientid'];
$doctorid = $_SESSION['doctorid'];
$doctor = false;

if ($_SESSION['admin'] != false) {
    $appointments = $conn->getAllAppointments($doctorid);
    $doctor = true;
} else if ($_SESSION['admin'] != true) {
    $appointments = $conn->fetchAppointments($patientid);
}
// $selectedDate = mktime(0,0,0,$_POST['month'], $_POST['date'], $_POST['year']);
// $weekday = intval(date('N', $selectedDate)) - 1;
// $monthNm = date('F', $selectedDate);
// $selectedDateNum = $_POST['date'];

// SET CURRENT DATE SELECTION WITH PHP
// function checkSelected($date) {
//     if ($date == 1) {
//         return 'highlight-date';
//     }
// }

// ADD DATE POSTFIX
// function checkDates($dates) {
//     return array_filter($dates, function ($e) {
//         global $selectedDateNum;
//         return ($e == $selectedDateNum);
//     });
// }



// if (checkDates(['1','21','31'])) {
//     $postfix = 'st';
// } else if (checkDates(['2','22'])) {
//     $postfix = 'nd';
// } else if (checkDates(['3','23'])) {
//     $postfix = 'rd';
// } else {
//     $postfix = 'th';
// }

function buildCalendar($month, $year) {
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberOfDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];
    $dateToday = date('Y-m-d');
    $prevMonth = date('m', mktime(0, 0, 0, $month - 1, 1, $year));
    $prevMonthName = date('M', mktime(0, 0, 0, $month - 1, 1, $year));
    $nextMonth = date('m', mktime(0, 0, 0, $month + 1, 1, $year));
    $nextMonthName = date('M', mktime(0, 0, 0, $month + 1, 1, $year));
    $prevYear = date('Y', mktime(0, 0, 0, $month - 1, 1, $year));
    $nextYear = date('Y', mktime(0, 0, 0, $month + 1, 1, $year));
    $calendar = "<div><h2>1. Choose a date</h2><div>";
    $calendar .= "<div class='calendar-heading'>";
    if ($prevMonth >= date('m')) {
        // previous month
        $calendar .= "<a href='?month=".$prevMonth."&year=".$prevYear."'>&lt; ".$prevMonthName."</a>";
    } else {
        // current month
        $calendar .= "<a href='?month=".($prevMonth + 1)."&year=".date('Y')."'>&lt; ".$prevMonthName."</a>";
    }
    $calendar .= "<a class='no-highlight' href='?month=".date('m')."&year=".date('Y')."'><span>".$monthName." ".$year."</span></a>";
    if ($nextMonth <= (date('m') + 2)) {
        $calendar .= "<a href='?month=".$nextMonth."&year=".$nextYear."'>".$nextMonthName." &gt;</a></div>";
    } else {
        $calendar .= "<a href='?month=".($nextMonth - 1)."&year=".$nextYear."'>".$nextMonthName." &gt;</a></div>";
    }
    $firstDayCurMonth = date('N', mktime(0, 0, 0, $month, 1, date('Y')));
    $calendar .= "<form class='datesArea'>";
    $daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'];
    for ($d = 0; $d < 7; $d++) {
        $calendar .= "<div class='calendar-element-days'>$daysOfWeek[$d]</div>";
    }
    for ($space = 1; $space < $firstDayCurMonth; $space++) {
        $calendar .= "<div class='calendar-element' style='opacity: 0'></div>";
    }
    for ($c = 0; $c < $numberOfDays; $c++) {
        $i = $c + 1;
        $class = '';
        if (date('d') > $i && date('m') == date('m', $firstDayOfMonth)) {
            $class = 'inactiveDate';
        };
        $calendar .= "<div class='calendar-element $class' id='$i' type='submit' onclick='submitAppointmentDate($i, $month, $year)' name='querydate'>$i</div>";
        // $calendar .= "<input type='hidden' name='querymonth' value='".$month."'>";
        // $calendar .= "<input type='hidden' name='queryyear' value='".$year."'>";
        // $calendar .= "<a href='includes/checkavailability.inc.php?querydate=".$i."&querymonth=".$month."&queryyear=".$year."' class='calendar-element  ".checkSelected($i)."   '>".$i."</a>";
    }
    $calendar .= "</form></div></div>";
    return $calendar;

}

// $first = mktime(0, 0, 0, $month, 1, $year);
// $getDate = getdate($first);

if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = $_GET['month'];
    $year = $_GET['year'];
    $monthName = date('M', mktime(0,0,0,$month,1,$year));
} else {
    $month = date('m');
    $year = date('Y');
}
?>

<?php if (!$doctor) : ?>

    <?php include_once 'includes/patientappointments.inc.php' ?>

<?php else : ?>

    <?php include_once 'includes/doctorappointments.inc.php' ?>

<?php endif; ?>

<div>
</div>

<div class="res-area"></div>

<?php require_once 'includes/footer.inc.php'; ?>