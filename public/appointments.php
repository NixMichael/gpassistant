<?php


require_once 'includes/header.inc.php';
require_once '../app/config.php';
require_once '../app/libraries/Database.class.php';

session_start();

if (empty($_SESSION['useremail'])) {
    header('Location: /');
}

$conn = new Database();

$username = $_SESSION['useremail'];

$appointments = $conn->fetchAppointments($username);
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
        $calendar .= "<a href='?month=".$prevMonth."&year=".$prevYear."'>&lt; ".$prevMonthName."</a>";
    } else {
        $calendar .= "<a href='?month=".($prevMonth + 1)."&year=".date('Y')."'>&lt; ".$prevMonthName."</a>";
    }
    $calendar .= "<a href='?month=".date('m')."&year=".date('Y')."'><span>".$monthName." ".$year."</span></a>";
    if ($nextMonth <= (date('m') + 2)) {
        $calendar .= "<a href='?month=".$nextMonth."&year=".$nextYear."'>".$nextMonthName." &gt;</a></div>";
    } else {
        $calendar .= "<a href='?month=".($nextMonth - 1)."&year=".$nextYear."'>".$nextMonthName." &gt;</a></div>";
    }
    $calendar .= "<form class='datesArea'>";
    for ($c = 0; $c < $numberOfDays; $c++) {
        $i = $c + 1;
        $calendar .= "<div class='calendar-element' id='$i' type='submit' onclick='submitAppointmentDate($i, $month, $year)' name='querydate'>$i</div>";
        // $calendar .= "<input type='hidden' name='querymonth' value='".$month."'>";
        // $calendar .= "<input type='hidden' name='queryyear' value='".$year."'>";
        // $calendar .= "<a href='includes/checkavailability.inc.php?querydate=".$i."&querymonth=".$month."&queryyear=".$year."' class='calendar-element  ".checkSelected($i)."   '>".$i."</a>";
    }
    $calendar .= "</form></div></div>";
    return $calendar;

}

// $first = mktime(0, 0, 0, $month, 1, $year);
// $getDate = getdate($first);

if ($_GET['month'] && $_GET['year']) {
    $month = $_GET['month'];
    $year = $_GET['year'];
    $monthName = date('M', mktime(0,0,0,$month,1,$year));
} else {
    $month = date('m');
    $year = date('Y');
}
?>

<?php if (!$_GET['month']) : ?>
<div class="current-appointments">
    <?php if (!$appointments) : ?>
        <div>No upcoming appointments.</div>
        <!-- <div class='button' onclick="showBooking()">Make an appointment</div> -->
        <a class='button' href="?month=<?php echo $month ?>">Make an appointment</a>
    <?php else : ?>
        <div>Upcoming appointments:</div>
        <div class='booked-appointment'><span><?php echo "Date: ".$appointments[0]['day'] ?></span><span><?php echo "Time: ".$appointments[0]['time'] ?></span><span>Doctor: <?php echo $appointments[0]['doctor_id'] ?: 'Unassigned' ?></span></div>
        <div class='booked-appointment appointment-note'><strong>Message to doctor:&emsp;</strong><?php echo $appointments[0]['notes'] ?: 'None provided' ?></div>
        <a class="button" href="includes/cancelappointment.inc.php?id=<?php echo $appointments[0]['id'] ?>&time=<?php echo $appointments[0]['time'] ?>">Cancel Appointment</a>
    <?php endif; ?>
</div>
<?php endif; ?>
<div class='container appointments-container'>
    <div class='calendar-area'>
        <div id='choose-date'>
            <?php echo buildCalendar($month, $year); ?>
        </div>
        <div id='choose-time'>
            <div><h2>2. Choose a time</h2></div>
            <form action="/bookappointment.php" method="POST" class="results">
                <div class="times-heading"></div>
                <div class="results-area"></div>
            </form>
        </div>
    </div>
</div>

<div>
</div>

<div class="res-area"></div>

<?php require_once 'includes/footer.inc.php'; ?>