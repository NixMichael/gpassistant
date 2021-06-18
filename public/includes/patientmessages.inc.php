<div class="messages">
            <div class='message-header'>
            <h3>Hi <?php echo ucfirst($_SESSION['username']) ?>, here are your messages:</h3>
            <div><a class='message-button' href='?newmessage'>Send Message</a><a class='message-button' href=''>Refresh</a></div>
            </div>
            <div class=results-header><span>From</span><span>Date</span><span>Message</span></div>
            <div class='msg-area msg-area-patient'>
            <ul>
            <?php 
            if (!is_array($msgs)) {
                echo $msgs;
            } else {
                foreach($msgs as $msg) {
                    $datetime = explode(' ', $msg['date']);
                    $date = $datetime[0];
                    $time = $datetime[1];
                    $sender = $msg['sender'] == 'D' ? 'doctor' : $msg['username'];
                    $acceptAppt = $_SESSION['admin'] == true ? "<input type='checkbox'/>" : "<span>Accept Appointment: <input type='checkbox'/></span>";
                    echo "<li class='".$sender."'><span>$msg[patientid]</span><span>$date <br> ($time)</span> $msg[msg]</li>";
                }
            };
            
            echo "</ul>";
            ?>
            <?php if (!$_SESSION['showall']) : ?>
                <a class='message-button' href='?showAll=true'>View All</a>
            <?php else : ?>
                <a class='message-button' href='?showAll=false'>Show Less</a>
            <?php endif ?>
            </div>
        </div>