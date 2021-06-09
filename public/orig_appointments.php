<?php 
$days=array();
$month = date('m') + 1;
$year = date('Y');

function monthMinus () {
    $month -= 1;
}

require_once '../app/config.php';
require_once '../app/libraries/Database.class.php';

if (isset($_POST['submit'])) {
    $chosenDay = $_GET['day'];
    $chosenTime = $_POST['submit'];
    $chooseAppt = new Database();

    $success = $chooseAppt->addAppointment($chosenDay, $chosenTime);

    header("Location: /appointmentbooked.php?booked=$success");
}

require_once 'includes/checktimes.inc.php';
require_once 'includes/header.inc.php';
?>

<div class="container">
    <h4>Select a date from the calendar and then choose an appointment time from the list to book.</h4>

    <div class="calendar">
        <div class="dates">
            <h2>1. Select a date</h2>
            <div class="navigate-dates">
                <span class="nav-months" onclick="monthMinus()"><</span><span id="current-month"><?php echo date('F') ?></span><span class="nav-months" onclick="monthPlus()">></span>
            </div>
            <div class="date-selection"></div>
        </div>
        <div class="times">
            <h2>2. Select a time</h2>
            <?php if (isset($_GET['day'])) : ?>
            <h3>Available appointments on <?php echo $_GET['day']."th ".$_GET['month'] ?></h3>
            <div class="time-slots">
                <form action="" method="POST">
                <?php
                    if (!empty($times)) {
                        foreach($times as $timeslot) {
                            $timePass = preg_replace("/[^0-9]/", '', $timeslot);
                            echo "<input type='submit' name='submit' class='slot' value='$timePass'/>";
                        }
                    }
                ?>
                </form>
                <?php echo $chosenTime ?>
            </div>
            <?php else : ?>
                <h4>No times available on your selected date</h4>
            <?php endif ?>
        </div>
    </div>

</div>

<script>
    let month = new Date().getMonth()
    const currentMonth = document.getElementById('current-month')
    const datesContainer = document.querySelector('.date-selection')
    const timeSlots = document.querySelector('.time-slots')
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']

    currentMonth.textContent = months[month]


    const updateDays = (month = new Date().getMonth()) => {
        let daysCount
        if (month === 8 || month === 3 || month === 5 || month === 10) {
            daysCount = 30
        } else {
            daysCount = 31
        }

        const year = new Date().getYear()
        let isLeapYear = (year % 4 === 0) && (year % 100 !== 0) || (year % 400 === 0)
        if (month === 1 && isLeapYear) {
            daysCount = 29
        }

        let updatedDates = ''
        for (let d = 0; d < daysCount; d++) {
            updatedDates += `<a class="day" href="<?php echo $_SERVER['PHP_SELF']; ?>?day=${d + 1}&month=${months[month]}">${d + 1}</a>`
        }
        datesContainer.innerHTML = updatedDates
    }

    updateDays()

    const monthMinus = () => {
        month = month > 0 ? month -= 1 : 11
        currentMonth.textContent = months[month]
        updateDays(month)
    }

    const monthPlus = () => {
        month = month < 11 ? month += 1 : 0
        currentMonth.textContent = months[month]
        updateDays(month)
    }

    const chooseTimeSlot = ($timeslot) => {
        alert($timeslot)
    }
</script>

<?php require_once 'includes/footer.inc.php' ?>