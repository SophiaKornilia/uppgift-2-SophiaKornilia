<?php
include_once('includes/functions.php');
$title = "subscriber account";
include_once('includes/header.php');

// Visa meddelandet i 3 sekunder innan omdirigering
echo '<meta http-equiv="refresh" content="3; url=login.php">';
?>
<div class="subscriber-container" style="display: flex; flex-direction: column; align-items: center">
    <h1>Successfully changed password!</h1>
</div>
<?php
include_once('includes/footer.php')
?>