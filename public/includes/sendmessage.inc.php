<?php

session_start();

require_once '../../app/config.php';
require_once '../../app/libraries/Messages.class.php';

$user = $_SESSION['patient_id'];
$message = $_POST['message'];

if (!isset($_POST['submit'])) {
    header('Location: /messages.php');
    exit();
}

$conn = new Messages();

$result = $conn->addMessage($user, $message, 'P');

if ($result) {
    header('Location: /messages.php?status=msgsent');
} else {
    header('Location: /messages.php?status=msgfailed');
}