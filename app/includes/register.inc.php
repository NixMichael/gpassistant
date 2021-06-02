<?php

session_start();

require_once '../app/config.php';
require_once '../app/libraries/Database.class.php';

$conn = new Database();

if (!isset($_POST['submit'])) {
    header('Location: /index.php');
} else {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rptPassword = $_POST['repeatPassword'];

    if (!$email) {
        header('Location: /index.php?error=emptyemail');
        exit();
    }

    if (!$username) {
        header('Location: /index.php?error=emptyusername');
        exit();
    }

    if (!$password) {
        header('Location: /index.php?error=emptypassword');
        exit();
    }

    if (!$rptPassword) {
        header('Location: /index.php?error=emptyrepeatpassword');
        exit();
    }

    $existing = $conn->existingUser($email, $username);

    if ($existing < 1) {
        $_SESSION['useremail'] = $email;
        header('Location: /messages.php');
    } else {
        header('Location: /index.php?error=userexists');
    }
}