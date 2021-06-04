<?php
require_once '../app/includes/login.inc.php';
require_once '../app/includes/header.inc.php';

$loggedIn = isset($_SESSION['useremail']) ? true : false;
?>

<div class="container">
    <?php echo $_GET['status'] == 'successfullyregistered' ? '<h3>Registration complete. Now please sign in.</h3>' : ''; ?>
    <?php if (!$loggedIn): ?>
    <div class="logIn">
        <h3>Log In</h3>
        <form action="" method="POST">
            <input type="text" name="email" placeholder="email" value="<?php echo isset($_SESSION['']) ?>" autocomplete="off"/>
            <span class="fielderror"><?php if (isset($_GET['error']) && $_GET['error'] == 'emptyemail') { echo 'email field required'; } ?></span>
            <input type="password" name="password" placeholder="password" autocomplete="off"/>
            <span class="fielderror"><?php 
                if (isset($_GET['error']) && $_GET['error'] == 'emptypassword') {
                    echo 'Password field required';
                } else if (isset($_GET['error']) && $_GET['error'] == 'failedlogin') {
                    echo 'Username and/or password incorrect';
                }
            ?></span>
            <input type="submit" name="submit" value="Log In"/>
            <a href="/register.php">Not registered yet?</a>
        </form>
    </div>
    <?php else: ?>
        <div>Home</div>
    <?php endif; ?>
</div>

<?php require_once '../app/includes/footer.inc.php'; ?>