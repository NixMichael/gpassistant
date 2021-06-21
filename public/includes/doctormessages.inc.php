<div class="messages">
    <div class='message-header'>
    <h3>Messages awaiting response:</h3>
    <div><a class='message-button' href=''>Refresh</a></div>
    </div>
    <div class=results-header><div><span>From</span><span>Date</span></div><div><span>Message</span></div></div>
    <div class='msg-area msg-area-gp'>
    <ul>
    <?php 

        if (empty($msgs['read'])) {
            echo 'No messages to display.';
        } else {


        $condensedList = [];

        foreach($msgs['read'] as $i) {
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
                $listCount += 1;
                $datetime = explode(' ', $msg['date']);
                $date = $datetime[0];
                $time = $datetime[1];
                $sender = $msg['sender'] == 'D' ? 'doctor' : '';
                $acceptAppt = $_SESSION['admin'] == true ? "<input type='checkbox'/>" : "<span>Accept Appointment: <input type='checkbox'/></span>";
                echo "<li class='".$sender."'><div><span>$msg[patientid]</span><span>$date <br> ($time)</span></div><div><span>$msg[msg]</span><form action='' method='GET'><button type='submit' name='msgid' value='$msg[msgid]'>Open</button><input type='hidden' name='read' value='read'/></form></div></li>";
            }
        }

    ?>

    </div>
</div>

<div class="messages">
    <div class='message-header'>
    <h3>Previous messages:</h3>
    <div><a class='message-button' href=''>Refresh</a></div>
    </div>
    <div class=results-header><div><span>From</span><span>Date</span></div><div><span>Message</span></div></div>
    <div class='msg-area msg-area-gp'>
    <ul>
    <?php    

        if (empty($msgs['unread'])) {
            echo 'No messages to display';
        } else {


            $condensedList = [];

            foreach($msgs['unread'] as $i) {
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
                $listCount += 1;
                $datetime = explode(' ', $msg['date']);
                $date = $datetime[0];
                $time = $datetime[1];
                $sender = $msg['sender'] == 'D' ? 'doctor' : '';
                $acceptAppt = $_SESSION['admin'] == true ? "<input type='checkbox'/>" : "<span>Accept Appointment: <input type='checkbox'/></span>";
                echo "<li class='".$sender."'><div><span>$msg[patientid]</span><span>$date <br> ($time)</span></div><div><span>$msg[msg]</span><form action='' method='GET'><button type='submit' name='msgid' value='$msg[msgid]'>Open</button><input type='hidden' name='read' value='unread'/></form></div></li>";
            }
        }

    ?>
    </div>
</div>

<script>
    let messageStream = document.querySelector('.message-stream');
    messageStream.scrollTop = messageStream.scrollHeight;
</script>