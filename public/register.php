<?php session_start(); 

if (!empty($_SESSION['useremail'])) {
    header('Location: /messages.php');
}

?>

<?php require_once 'includes/header.inc.php'; ?>

<div class="container">
    <div class="logIn">
        <h3>Register</h3>
        <form action="includes/register.inc.php" method="POST">
            <input type="text" name="email" placeholder="Email" autocomplete="off"/>
            <span class="fielderror"><?php if (isset($_GET['error']) && $_GET['error'] == 'emptyemail') { echo 'email field required'; } ?></span>
            <input type="text" name="username" placeholder="Username" autocomplete="off"/>
            <span class="fielderror"><?php if (isset($_GET['error']) && $_GET['error'] == 'emptyusername') { echo 'username field required'; } ?></span>
            <input type="password" name="password" placeholder="Password" autocomplete="off"/>
            <span class="fielderror"><?php if (isset($_GET['error']) && $_GET['error'] == 'emptypassword') { echo 'password field required'; } ?></span>
            <input type="password" name="repeatPassword" placeholder="Repeat password" autocomplete="off"/>
            <span class="fielderror"><?php if (isset($_GET['error']) && $_GET['error'] == 'emptypassword') { echo 'password field required'; } ?></span>
            <input type="submit" name="submit" value="Register"/>
            <a href="/">Already registered?</a>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.inc.php'; ?>