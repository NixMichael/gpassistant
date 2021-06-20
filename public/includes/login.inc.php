<?php

require_once '../../app/config.php';
require_once '../../app/libraries/Login.class.php';

$conn = new Login();

// $errors = ['email' => '', 'password' => '', 'failedlogin' => ''];

if (empty($_POST['submit'])) {
    header('Location: /index.php');
    exit();
} else {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $email = trim($email);
    $password = trim($password);
    
    if (!$email) {
        // $errors['email'] = 'email field required';
        header('Location: /index.php?error=emptyemail');
        exit();
    }
    
    if (!$password) {
        // $errors['password'] = 'Password field required';
        header("Location: /index.php?error=emptypassword");
        exit();
    }

    $user = $conn->logIn($email);
    $user = $user[0];

    if (password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['useremail'] = $email;
        $_SESSION['username'] = $user['username'];
        if (!$user['admin']) {
            $_SESSION['patientid'] = $user['patient_id'];
        } else {
            $_SESSION['doctorid'] = $user['email'];
            $_SESSION['doctorname'] = $user['username'];
        }
        $_SESSION['admin'] = $user['admin'];
        header('Location: /messages.php');
    } else {
        // $errors['failedlogin'] = 'Username and/or password incorrect';
        header('Location: /index.php?error=failedlogin');
        exit();
    }
}