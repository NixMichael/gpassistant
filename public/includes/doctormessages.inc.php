
<div class="messages">
    <div class='message-header'>
    <h3>Your unread messages:</h3>
    <div><a class='message-button' href=''>Refresh</a></div>
    </div>
    <div class=results-header><span>From</span><span>Date</span><span>Message</span></div>
    <div class='msg-area'>
    <ul>
    <?php 
    if (empty($msgs)) {
        echo 'No messages';
    } else {
        $condensedList = [];

        foreach($msgs as $i) {
            $in = false;
            if (!empty($condensedList)) {
                for($c = 0; $c < sizeof($condensedList); $c++) {
                    if ($condensedList[$c]['patientid'] == $i['patientid']) {
                        $condensedList[$c] = $i;
                        $in = true;
                        break;
                    }
                }
                if (!$in) {
                    $condensedList[] = $i;
                }
            } else {
                $condensedList[] = $i;
            }
        }

        $listCount = 0;
        foreach($condensedList as $msg) {
            if ($msg['readreceipt'] != 1) {
                $listCount += 1;
                $datetime = explode(' ', $msg['date']);
                $date = $datetime[0];
                $time = $datetime[1];
                $sender = $msg['sender'] == 'D' ? 'doctor' : '';
                $acceptAppt = $_SESSION['admin'] == true ? "<input type='checkbox'/>" : "<span>Accept Appointment: <input type='checkbox'/></span>";
                echo "<li class='".$sender."'><span>$msg[patientid]</span><span>$date <br> ($time)</span><span>$msg[msg]</span><form action='' method='GET'><button type='submit' name='msgid' value='$msg[msgid]'>Open</button></form></li>";
            }
        }
    };

    echo "</ul>";
    ?>
    <?php if ($listCount != 0) {
        if (!$_SESSION['showall']) : ?>
            <a class='message-button' href='?showAll=true'>View All</a>
        <?php else : ?>
            <a class='message-button' href='?showAll=false'>Show Less</a>
        <?php endif; } else {
            echo "<div>No new messages</div>";
        } ?>
    </div>
</div>

<div class="messages">
    <div class='message-header'>
    <h3>Previous messages:</h3>
    <div><a class='message-button' href=''>Refresh</a></div>
    </div>
    <div class=results-header><span>From</span><span>Date</span><span>Message</span></div>
    <div class='msg-area'>
    <ul>
    <?php 
    if (empty($msgs)) {
        echo 'No messages';
    } else {
        $condensedList = [];

        foreach($msgs as $i) {
            $in = false;
            if (!empty($condensedList)) {
                for($c = 0; $c < sizeof($condensedList); $c++) {
                    if ($condensedList[$c]['patientid'] == $i['patientid']) {
                        $condensedList[$c] = $i;
                        $in = true;
                        break;
                    }
                }
                if (!$in) {
                    $condensedList[] = $i;
                }
            } else {
                $condensedList[] = $i;
            }
        }

        $listCount = 0;

        foreach($condensedList as $msg) {
            if ($msg['readreceipt'] == 1) {
                $listCount += 1;
                $datetime = explode(' ', $msg['date']);
                $date = $datetime[0];
                $time = $datetime[1];
                $sender = $msg['sender'] == 'D' ? 'doctor' : '';
                $acceptAppt = $_SESSION['admin'] == true ? "<input type='checkbox'/>" : "<span>Accept Appointment: <input type='checkbox'/></span>";
                echo "<li class='".$sender."'><span>$msg[patientid]</span><span>$date <br> ($time)</span><span>$msg[msg]</span><form action='' method='GET'><button type='submit' name='msgid' value='$msg[msgid]'>Open</button></form></li>";
            }
        }
    };

    echo "</ul>";
    ?>
    <?php if ($listCount != 0) {
        if (!$_SESSION['showall']) : ?>
            <a class='message-button' href='?showAll=true'>View All</a>
        <?php else : ?>
            <a class='message-button' href='?showAll=false'>Show Less</a>
        <?php endif; } else {
            echo "<div>No previous messages</div>";
        } ?>
    </div>
</div>