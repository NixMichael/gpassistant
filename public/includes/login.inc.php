<?php

require_once '../../app/config.php';
require_once '../../app/libraries/Database.class.php';

$conn = new Database();

session_start();

if (empty($_POST['submit'])) {
    header('Location: /messages.php');
} else {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $email = trim($email);
    $password = trim($password);

    if (!$email) {
        header('Location: /index.php?error=emptyemail');
        exit();
    }

    if (!$password) {
        header('Location: /index.php?error=emptypassword');
        exit();
    }

    $user = $conn->logIn($email);

    if (password_verify($password, $user['password'])) {
        $_SESSION['useremail'] = $email;
        header('Location: /messages.php');
    } else {
        header('Location: /index.php?error=failedlogin');
    }
}