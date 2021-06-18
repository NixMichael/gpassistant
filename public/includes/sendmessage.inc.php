<?php

session_start();

require_once '../../app/config.php';
require_once '../../app/libraries/Messages.class.php';


if (!isset($_POST['submit'])) {
    header('Location: /messages.php');
    exit();
} else {

    $user = $_SESSION['patientid'];
    $message = $_POST['message'];

    $conn = new Messages();

    $result = $conn->addMessage($user, $message, 'P');

    if ($result) {
        header('Location: /messages.php?status=msgsent');
    } else {
        header('Location: /messages.php?status=msgfailed');
    }
}