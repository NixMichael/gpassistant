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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script defer src="js/app.js"></script>
    <title>GP</title>
    <link rel="icon" href="../includes/favicon.ico" type="image/x-icon">
</head>
<body>
<header>
    <h1>GP<span>ASSISTANT</span></h1>
    <nav>
        <ul class='menu'>
            <?php if (!isset($_SESSION['useremail'])): ?>
                <li><a href="/">Log In</a></li>
                <li><a href="/register.php">Register</a></li>
            <?php else: ?>
                <li><a href="/appointments.php">My Appointments</a></li>
                <li><a href="/messages.php">My Messages</a></li>
                <li><a href="/includes/logout.inc.php">Log Out</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<div class="container">