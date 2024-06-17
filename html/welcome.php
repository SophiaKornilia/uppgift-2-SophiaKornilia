<?php
include_once('includes/functions.php');
$title = "subscriber account";
include_once('includes/header.php');
?>
<?php
if (!isset($_SESSION['isloggedin']) || $_SESSION['isloggedin'] !== true) {
    header('Location: login.php');
    exit;
};
//hämta användarens roll och id från session
$userRole = $_SESSION['role'];
$userId = $_SESSION['user_id'];



var_dump($_SESSION);

?>
<div class="subscriber-container" style="display: flex; flex-direction: column; align-items: center">
    <?php
    echo "<h1>Welcome to your account</h1>";
    echo "<p>Role: $userRole</p>";
    ?>
</div>
<?php
include_once('includes/footer.php')
?>