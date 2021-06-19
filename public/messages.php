<?php

require_once '../app/config.php';
require_once '../app/libraries/Messages.class.php';

session_start();

if (empty($_SESSION['useremail'])) {
    header('Location: /');
}

$conn = new Messages();

if (isset($_GET['showAll']) && $_GET['showAll'] == 'true') {
    $_SESSION['showall'] = true;
} else if (isset($_GET['showAll']) && $_GET['showAll'] == 'false') {
    $_SESSION['showall'] = false;
} else if (empty($_SESSION['showall'])) {
    $_SESSION['showall'] = false;
}

$msgs = $conn->fetchMessages($_SESSION['patientid'], $_SESSION['showall'], $_SESSION['admin']);

if (is_array($msgs)) {
    $msgs = array_reverse($msgs);
}

require_once 'includes/header.inc.php'; ?>

<div class="msg-container">
    <?php if (isset($_SESSION['useremail']) && $_SESSION['useremail'] == false): ?>
        <div>
            <h3>Not logged in</h3>
        </div>
    <?php else: ?>
        <div class='message-panels'>
        <?php
            if (!$_SESSION['admin']) {
                include_once 'includes/patientmessages.inc.php';
            } else {
                include_once 'includes/doctormessages.inc.php';
            }
        ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['newmessage'])) : ?>
        <div class="newMessageContainer">
            <div class="newMessage">
                <h3>Compose a new message:</h3>
                <p>(Once you have submitted a message it cannot be deleted as it will legally form part of your medical records)</p>
                <form action="includes/sendmessage.inc.php" method="POST">
                    <textarea name="message"></textarea>
                    <input type="submit" name="submit" value="Send Message">
                    <input type="submit" name="cancel" value="Cancel">
                </form>
            </div>
        </div>
    <?php endif ?>
    <?php if (isset($_GET['msgid'])) : ?>
        <div class="newMessageContainer">
        <div class="newMessage">
        <?php
            foreach($msgs as $msg) {
                if ($msg['msgid'] == $_GET['msgid']) {
                    $curMsg = $msg;
                    break;
                }
            }

            $msgStream = $conn->fetchMessageStream($curMsg['patientid']);
        ?>
                <div>New message to: <?php echo $curMsg['patientid'] ?></div>
                <ul class='message-stream'><?php 
                    if (!empty($msgStream)) {
                        foreach($msgStream as $msg) {
                            $class = $msg['sender'] == 'D' ? 'doctor' : '';
                            echo "<li class='$class'>$msg[message]</li>";
                        }
                    } else {
                        echo 'No messages to display.';
                    } ?>
                </ul>
                <form action="includes/gpsendmessage.inc.php" method="POST">
                    <textarea name="message" placeholder="Type your new message here..."></textarea>
                    <button type="submit" name="submit" value="<?php echo $curMsg['patientid'] ?>">Send Message</button>
                    <input type="submit" name="cancel" value="Close">
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.inc.php'; ?>