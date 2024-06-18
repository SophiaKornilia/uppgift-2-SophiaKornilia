<?php
include_once('includes/functions.php');
$title = "successfully signed out";
include_once('includes/header.php');

// Visa meddelandet i 3 sekunder innan omdirigering
echo '<meta http-equiv="refresh" content="3; url=login.php">';
?>
<div class="subscriber-container" style="display: flex; flex-direction: column; align-items: center">
    <h1>Your account was successfully logged out!</h1>
</div>
<?php
include_once('includes/footer.php')
?>