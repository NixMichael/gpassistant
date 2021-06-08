<?php

require_once 'includes/header.inc.php';

function buildCalendar($month, $year) {
    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberOfDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];
    $dateToday = date('Y-m-d');
    $prevMonth = date('m', mktime(0, 0, 0, $month - 1, 1, $year));
    $nextMonth = date('m', mktime(0, 0, 0, $month + 1, 1, $year));
    $prevYear = date('Y', mktime(0, 0, 0, $month - 1, 1, $year));
    $nextYear = date('Y', mktime(0, 0, 0, $month + 1, 1, $year));
    $calendar = "<div><h2>Choose a date</h2><div><h2>$monthName $year</h2>";
    $calendar .= "<div class='flexCal'><a href='?month=".$prevMonth."&year=".$prevYear."'>Prev Month</a>";
    $calendar .= "<a href='?month=".date('m')."&year=".date('Y')."'>Current Month</a>";
    $calendar .= "<a href='?month=".$nextMonth."&year=".$nextYear."'>Next Month</a></div>";
    $calendar .= "<div class='flexCal'>";
    foreach($daysOfWeek as $day) {
        $calendar .= "<div class='dayBox'>".$day."</div>";
    }
    $calendar .= "</div><div class='datesArea'>";
    for ($c = 0; $c < $numberOfDays; $c++) {
        $i = $c + 1;
        $calendar .= "<a href='includes/checkavailability.inc.php?queryday=".$i."&querymonth=".$monthName."&queryyear=".$year."' class='testCal'>".$i."</a>";
        if (!(($i) % 7)) {
            $calendar .= "</div><div class='datesArea'>";
        }
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
    <div class='calendar-are'>
        <div>
            <?php echo buildCalendar($month, $year); ?>
        </div>
        <div>
            <h2>Choose a time</h2>
            <div class="results">
                <?php if (isset($_GET['result'])) {
                    $result = json_decode($_GET['result']);
                }
                foreach($result as $time) : ?>
                    <a class='result' href='#'>
                        <?php echo $time ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>