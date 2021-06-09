<?php

require_once 'includes/header.inc.php';

$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$selectedDate = mktime(0,0,0,$_POST['month'], $_POST['date'], $_POST['year']);
$weekday = intval(date('N', $selectedDate)) - 1;
$monthNm = date('F', $selectedDate);
$selectedDateNum = $_POST['date'];

function checkDates($dates) {
    return array_filter($dates, function ($e) {
        global $selectedDateNum;
        return ($e == $selectedDateNum);
    });
}

if (checkDates(['1','21','31'])) {
    $postfix = 'st';
} else if (checkDates(['2','22'])) {
    $postfix = 'nd';
} else if (checkDates(['3','23'])) {
    $postfix = 'rd';
} else {
    $postfix = 'th';
}

function buildCalendar($month, $year) {
    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
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
    $calendar = "<div><h2>Choose a date</h2><div><h2>$monthName $year</h2>";
    $calendar .= "<div class='navCal'><a href='?month=".$prevMonth."&year=".$prevYear."'>&lt; ".$prevMonthName."</a>";
    $calendar .= "<a href='?month=".date('m')."&year=".date('Y')."'>Current Month</a>";
    $calendar .= "<a href='?month=".$nextMonth."&year=".$nextYear."'>".$nextMonthName." &gt;</a></div>";
    // Days of week
    // $calendar .= "<div class='flexCal'>";
    // foreach($daysOfWeek as $day) {
    //     $calendar .= "<div class='dayBox'>".$day."</div>";
    // }
    $calendar .= "<div class='datesArea'>";
    for ($c = 0; $c < $numberOfDays; $c++) {
        $i = $c + 1;
        $calendar .= "<a href='includes/checkavailability.inc.php?querydate=".$i."&querymonth=".$month."&queryyear=".$year."' class='testCal'>".$i."</a>";
    }
    $calendar .= "</div></div></div>";
    return $calendar;

}

$first = mktime(0, 0, 0, $month, 1, $year);
$getDate = getdate($first);

if ($_GET['month'] && $_GET['year']) {
    $month = $_GET['month'];
    $year = $_GET['year'];
} else {
    $month = $getDate['mon'];
    $year = $getDate['year'];
}
?>

<div class='container'>
    <h4>Select a date from the calendar and then choose an appointment time from the list to book.</h4>
    <div class='calendar-area'>
        <div>
            <?php echo buildCalendar($month, $year); ?>
        </div>
        <div>
            <h2>Choose a time on <?php echo $daysOfWeek[$weekday]." ".$selectedDateNum.$postfix." ".$monthNm." ".$_GET['year']; ?></h2>
            <form action="/bookappointment.php" method="POST" class="results">
                <?php if (isset($_POST['result'])) {
                    $result = json_decode($_POST['result']);
                }
                foreach($result as $time) : ?>
                    <input type="submit" name="time" value="<?php echo $time ?>" class='result'>
                    <input type="hidden" name="date" value="<?php echo $selectedDateNum ?>">
                    <input type="hidden" name="month" value="<?php echo $_POST['month'] ?>">
                    <input type="hidden" name="year" value="<?php echo $_POST['year'] ?>">
                <?php endforeach; ?>
            </form>
        </div>
    </div>
</div>