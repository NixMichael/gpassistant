<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet"> 
    <title>GP</title>
</head>
<body>
<header>
    <h1>GP<span>ASSISTANT</span></h1>
    <nav>
        <ul>
            <?php if (!isset($_SESSION['useremail'])): ?>
                <li><a href="/">Log In</a></li>
                <li><a href="/register.php">Register</a></li>
            <?php else: ?>
                <li><a href="/appointments">My Appointment</a></li>
                <li><a href="/messages">Messages</a></li>
                <li><a href="logout.inc.php">Log Out</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>