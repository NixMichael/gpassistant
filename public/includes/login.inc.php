<?php

require_once '../app/config.php';
require_once '../app/libraries/Database.class.php';

$conn = new Database();

$errors = ['email' => '', 'password' => '', 'failedlogin' => ''];

if (empty($_POST['submit'])) {
    // header('Location: /messages.php');
} else {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $email = trim($email);
    $password = trim($password);
    
    if (!$email) {
        $errors['email'] = 'email field required';
        // header('Location: /index.php?error=emptyemail');
        // exit();
    }
    
    if (!$password) {
        $errors['password'] = 'Password field required';
        // header("Location: /index.php?error=emptypassword&email=$email");
        // exit();
    }

    $user = $conn->logIn($email);
    
    if (password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['useremail'] = $email;
        header('Location: /messages.php');
    } else {
        $errors['failedlogin'] = 'Username and/or password incorrect';
        // header('Location: /index.php?error=failedlogin');
    }
}