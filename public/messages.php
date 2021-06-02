<?php

require_once '../app/config.php';
require_once '../app/libraries/Database.class.php';

$conn = new Database();

require_once '../app/includes/header.inc.php'; ?>

<div class="container">
    <?php if (!isset($_SESSION['useremail'])): ?>
        <div>
            <h3>Not logged in</h3>
        </div>
    <?php else: ?>
        <div class="module">
            <?php $result = $conn->fetchUser($_SESSION['useremail']);
            echo '<h4>Welcome '.$result.'!</h4>';
            ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../app/includes/footer.inc.php'; ?>