<?php require_once 'includes/header.inc.php' ?>

<div class="container">
    <h4>Appointments</h4>

    <div class="calendar">
        <div class="dates">
            <div class="navigate-dates">
                <span><</span><span class="current-month">June</span><span>></span>
            </div>
            <div class="date-selection">
                <?php for ($c = 1; $c < 32; $c++) : ?>
                    <div class="day"><?php echo $c ?></div>
                <?php endfor; ?>
            </div>
        </div>
        <div class="times">
            <h2>Timeslots</h2>
            <?php

            ?>
        </div>
    </div>

</div>

<?php require_once 'includes/footer.inc.php' ?>