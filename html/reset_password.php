<?php
$title = "subscriber account";
include_once('includes/header.php');
?>
<div class="subscriber-container" style="display: flex; flex-direction: column; align-items: center">
    <form method="POST" style="display: flex; flex-direction: column; margin-top:20px;">
        <h3>Reset password</h3>
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <label for="password">Current password</label>
        <input type="password" name="password" id="password">
        <label for="password">New password</label>
        <input type="password" name="password" id="password">
        <label for="password">Confirm new password</label>
        <input type="password" name="password" id="password">
        <input type="submit" style="margin-top: 20px;">
    </form>
</div>
<?php
include_once('includes/footer.php')
?>