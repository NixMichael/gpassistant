<?php
require_once 'includes/header.inc.php';
require_once 'includes/login.inc.php';

$loggedIn = isset($_SESSION['useremail']) ? true : false;
?>

<div class="container">
    <div>
    <?php echo $_GET['status'] == 'successfullyregistered' ? '<h3>Registration complete. Now please sign in.</h3>' : ''; ?>
    <?php if (!$loggedIn): ?>
    <div class="logIn">
        <h3>Log In</h3>
        <form action="" method="POST">
            <input type="text" name="email" placeholder="email" value="<?php echo $_POST['email'] ?>" autocomplete="off"/>
            <span class="fielderror"><?php 
                if (isset($errors['email'])) {
                    echo $errors['email'];
                }            
            ?></span>
            <input type="password" name="password" placeholder="password" autocomplete="off"/>
            <span class="fielderror"><?php 
                if (isset($errors['password'])) {
                    echo $errors['password'];
                } else if (isset($errors['failedlogin'])) {
                    echo $errors['failedlogin'];
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
</div>

<?php require_once 'includes/footer.inc.php'; ?>