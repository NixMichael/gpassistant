<?php if (defined('APP_RAN')) : ?>

    <div class="log-in">
        <h3>Log In</h3>
        <form action="includes/login.inc.php" method="POST">
            <input type="text" name="email" placeholder="email" value="<?php echo isset($_SESSION['useremail']) ?>" autocomplete="off"/>
            <span class="field-error"><?php if (isset($_GET['error']) && $_GET['error'] == 'emptyemail') { echo 'email field required'; } ?></span>
            <input type="password" name="password" placeholder="password" autocomplete="off"/>
            <span class="field-error"><?php 
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

<?php else : header('Location: /index.php'); endif; ?>