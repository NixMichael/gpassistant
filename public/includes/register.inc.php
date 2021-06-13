<?php

require_once '../../app/config.php';
require_once '../../app/libraries/Database.class.php';

$conn = new Database();

if (empty($_POST['submit'])) {
    header('Location: /messages.php');
} else {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rptPassword = $_POST['repeatPassword'];

    if (!$email) {
        header('Location: /register.php?error=emptyemail');
        exit();
    }

    if (!$username) {
        header('Location: /register.php?error=emptyusername');
        exit();
    }

    if (!$password) {
        header('Location: /register.php?error=emptypassword');
        exit();
    }

    if (!$rptPassword) {
        header('Location: /register.php?error=emptyrepeatpassword');
        exit();
    }

    if ($password !== $rptPassword) {
        header('Location: /register.php?error=passwordmismatch');
        exit();
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $existing = $conn->existingUser($email, $username);

    if ($existing < 1) {
        $conn->registerUser($email, $username, $hash);
        header('Location: /index.php?status=successfullyregistered');
    } else {
        header('Location: /register.php?error=userexists');
    }
}