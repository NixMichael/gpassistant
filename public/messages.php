<?php

require_once '../app/config.php';
require_once '../app/libraries/Database.class.php';

session_start();

$conn = new Database();

if (isset($_GET['showAll']) && $_GET['showAll'] == 'true') {
    $_SESSION['showall'] = true;
} else if (isset($_GET['showAll']) && $_GET['showAll'] == 'false') {
    $_SESSION['showall'] = false;
} else if (empty($_SESSION['showall'])) {
    $_SESSION['showall'] = false;
}

$msgs = $conn->fetchMessages($_SESSION['useremail'], $_SESSION['showall']);

$msgs = array_reverse($msgs);

require_once 'includes/header.inc.php'; ?>

<div class="container msg-container">
    <?php if (isset($_SESSION['useremail']) && $_SESSION['useremail'] == false): ?>
        <div>
            <h3>Not logged in</h3>
        </div>
    <?php else: ?>
        <div class="messages">
            <?php 
            $username = $conn->fetchUser($_SESSION['useremail']);
            echo "<div class='message-header'>";
            echo '<h3>Hi '.ucfirst($username).', here are your messages:</h3>';
            echo "<div><a class='message-button' href='?newmessage'>Send Message</a><a class='message-button' href=''>Refresh</a></div>";
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
            <?php if (!$_SESSION['showall']) : ?>
                <a class='message-button' href='<?php echo $_SERVER['self'] ?>?showAll=true'>View All</a>
            <?php else : ?>
                <a class='message-button' href='<?php echo $_SERVER['self'] ?>?showAll=false'>Show Less</a>
            <?php endif ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['newmessage'])) : ?>
        <div class="newMessageContainer">
            <div class="newMessage">
                <h3>Compose a new message:</h3>
                <form action="includes/sendmessage.inc.php" method="POST">
                    <textarea name="message"></textarea>
                    <input type="submit" name="newmessage" value="Send Message">
                    <a href="/messages.php">Cancel</a>
                </form>
            </div>
        </div>
    <?php endif ?>
</div>

<?php require_once 'includes/footer.inc.php'; ?>