<?php

session_start();

require_once '../../app/config.php';
require_once '../../app/libraries/Database.class.php';

$user = $_SESSION['useremail'];
$message = $_POST['message'];

$conn = new Database();

$result = $conn->addMessage($user, $message, 'P');

if ($result) {
    header('Location: /messages.php?status=msgsent');
} else {
    header('Location: /messages.php?status=msgfailed');
}