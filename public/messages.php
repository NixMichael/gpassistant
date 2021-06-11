<?php

require_once '../app/config.php';
require_once '../app/libraries/Database.class.php';

session_start();

$conn = new Database();

$msgs = $conn->fetchMessages($_SESSION['useremail']);

require_once 'includes/header.inc.php'; ?>

<div class="container">
    <?php if (isset($_SESSION['useremail']) == false): ?>
        <div>
            <h3>Not logged in</h3>
        </div>
    <?php else: ?>
        <div class="messages">
            <?php 
            $username = $conn->fetchUser($_SESSION['useremail']);
            echo "<div class='message-header'>";
            echo '<h3>Hi '.ucfirst($username).', here are your messages:</h3>';
            echo "<div><a class='message-button' href=''>Send Message</a><a class='message-button' href=''>Refresh</a></div>";
            echo "</div>";
            echo "<div class='msg-area'>";
            echo "<ul>";
            if (empty($msgs)) {
                echo 'No messages';
            } else {
                foreach($msgs as $msg) {
                    $datetime = explode(' ', $msg['date']);
                    $date = $datetime[0];
                    $time = $datetime[1];
                    $sender = $msg['sender'] == 'D' ? 'Doctor' : 'You';
                    echo "<li class='".$sender."'><span>$sender</span><span>$date <br> ($time)</span> $msg[msg]</li>";
                }
            };
            
            echo "</ul>";
            ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.inc.php'; ?>