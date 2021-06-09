<?php

session_start();

require_once '../../app/config.php';
require_once '../../app/libraries/Database.class.php';

$conn = new Database();

if (isset($_POST['submit'])) {
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
        header('Location: /appointments.php');
    } else {
        header('Location: /index.php?error=failedlogin');
    }
}