<?php

require_once '../../app/config.php';
require_once '../../app/libraries/Messages.class.php';

if (!isset($_POST['submit'])) {
    header('Location: /messages.php');
    exit();
} else {

    $patientid = $_POST['submit'];
    $message = $_POST['message'];

    $conn = new Messages();

    $conn->markRead($patientid);

    $result = $conn->addMessage($patientid, $message, 'D');

    if ($result) {
        header('Location: /messages.php?status=msgsent');
    } else {
        header('Location: /messages.php?status=msgfailed');
    }
}