<?php
require_once 'includes/header.inc.php';

define('APP_RAN', true);

$loggedIn = isset($_SESSION['useremail']) ? true : false;
?>

<div class="container">
    <div>
    <?php
    if (isset($_GET['status']) && $_GET['status'] == 'successfullyregistered') { 
        echo '<h3>Registration complete. Now please sign in.</h3>';
    } ?>
    <?php if (!$loggedIn) {
        include_once 'includes/login.php';
    } else {
        echo 'Home';
    } ?>
    </div>
</div>

<?php require_once 'includes/footer.inc.php'; ?>