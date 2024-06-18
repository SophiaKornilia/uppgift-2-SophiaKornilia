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
<!-- <div class="subscriber-container" style="display: flex; flex-direction: column; align-items: center">
    <?php
    echo "<h1>Welcome to your account</h1>";
    echo "<p>Role: $userRole</p>";
    ?>
</div> -->
<div class="subscriber-container" style="display: flex; flex-direction: column; align-items: center; margin-top: 50px;">
    <div style="background-color: #f0f0f0; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: center;">
        <h1>Welcome to Your Subscriber Account</h1>
        <!-- <p style="font-size: 18px; margin-top: 10px;">Hello, <?php echo $userRole; ?> </p> -->
        <hr style="margin: 20px 0;">
        <div style="text-align: left;">
            <p>Thank you for logging in to your subscriber account. Here, you can manage your subscriptions and preferences easily.</p>
            <p>Explore the various newsletters and updates available to you. Stay informed with the latest news and updates tailored just for you.</p>
        </div>
    </div>
</div>
<?php
include_once('includes/footer.php')
?>