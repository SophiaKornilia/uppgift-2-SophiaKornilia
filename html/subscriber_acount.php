<?php
    $title = "customer account";
    include_once('includes/header.php');
?>
<div class="customer-container" style="display: flex; flex-direction: column; align-items: center">
    <form method="POST" style="display: flex; flex-direction: column; margin-top:20px;">
    <h3>Subscibe on our newsletter</h3>
        <label for="firstName">Firstname</label>
        <input type="text" name="firstName" id="firstName">
        <label for="lastName">Lastname</label>
        <input type="text" name="lastName" id="lastName">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <input type="submit" style="margin-top: 20px;">
    </form>
</div>

<?php
include_once('includes/footer.php')
?>