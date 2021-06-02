<?php require_once '../app/includes/header.inc.php'; ?>

<div class="container">
    <div class="logIn">
        <h3>Register</h3>
        <form action="" method="POST">
            <input type="text" name="email" placeholder="Email" autocomplete="off"/>
            <span class="fielderror"><?php if (isset($_GET['error']) && $_GET['error'] == 'emptyemail') { echo 'email field required'; } ?></span>
            <input type="text" name="username" placeholder="Username" autocomplete="off"/>
            <span class="fielderror"><?php if (isset($_GET['error']) && $_GET['error'] == 'emptyusername') { echo 'username field required'; } ?></span>
            <input type="password" name="password" placeholder="Password" autocomplete="off"/>
            <span class="fielderror"><?php if (isset($_GET['error']) && $_GET['error'] == 'emptypassword') { echo 'password field required'; } ?></span>
            <input type="password" name="password" placeholder="Repeat password" autocomplete="off"/>
            <span class="fielderror"><?php if (isset($_GET['error']) && $_GET['error'] == 'emptypassword') { echo 'password field required'; } ?></span>
            <input type="submit" name="submit" value="Register"/>
            <a href="/index.php">Already registered?</a>
        </form>
    </div>
</div>

<?php require_once '../app/includes/footer.inc.php'; ?>