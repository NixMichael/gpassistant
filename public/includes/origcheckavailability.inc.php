<?php

require_once '../../app/config.php';
require_once '../../app/libraries/Database.class.php';

$date = $_GET['querydate'];
$month = intval($_GET['querymonth']);
$year = $_GET['queryyear'];


$conn = new Database();

$response = $conn->checkTimes($date);

$times = array_filter(TIMELIST, function ($t) {
    global $response;
    $chk = [];
    foreach($response as $r) {
        if ($r == $t) {
            $chk[] = $t;
        }
    }
    if (!empty($chk)) {
        return false;
    } else {
        return true;
    }
});

$result = json_encode($times);

?>


<form id="form" action="/appointments.php" method="POST">
    <input type="hidden" name="result" value=?php echo $result?>>
    <input type="hidden" name= "date" value=?php echo $date?>>
    <input type="hidden" name= "month" value=?php echo $month?>>
    <input type="hidden" name= "year" value=?php echo $year?>>
</form>

<script>
    const frm = document.getElementById('form');
    frm.submit();
</script>