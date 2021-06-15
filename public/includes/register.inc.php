<?php

require_once '../../app/config.php';
require_once '../../app/libraries/Login.class.php';

$conn = new Login();

if (empty($_POST['submit'])) {
    header('Location: /messages.php');
} else {
    $patientId = intval($_POST['patientid']);
    $rptPatientId = intval($_POST['rptpatientid']);
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rptPassword = $_POST['repeatPassword'];

    if (!$patientId || !preg_match("/\d{9}/", $patientId)) {
        header('Location: /register.php?error=patientidlength');
        exit();
    }

    if ($patientId !== $rptPatientId) {
        header('Location: /register.php?error=patientidmismatch');
        exit();
    }

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

    $existing = $conn->existingUser($patientId, $email, $username);

    if ($existing < 1) {
        $conn->registerUser($patientId, $email, $username, $hash);
        header('Location: /index.php?status=successfullyregistered');
    } else {
        header('Location: /register.php?error=userexists');
    }
}