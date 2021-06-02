<?php

session_start();

require_once '../app/config.php';
require_once '../app/libraries/Database.class.php';

$conn = new Database();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!$email) {
        header('Location: /index.php?error=emptyemail');
        exit();
    }

    if (!$password) {
        header('Location: /index.php?error=emptypassword');
        exit();
    }

    $result = $conn->logIn($email, $password);

    if ($result === 1) {
        $_SESSION['useremail'] = $email;
        header('Location: /messages.php');
    } else {
        header('Location: /index.php?error=failedlogin');
    }
}