<?php
include_once('includes/functions.php');

if (isset($_GET['logout'])) {
    is_signed_out();
}
if (is_signed_in()) {
    include('includes/menu_subscriber.php');
} else {
    include('includes/menu_guest.php');
}
// if ($_SESSION['isloggedin'] === false) {
//     include('includes/menu_guest.php');
// } else if ($_SESSION['isloggedin'] === true) {
//     include('includes/menu_subscriber.php');
// } else {
//     include('includes/menu_customer.php');
// }
?>
<html>

<head>
    <title>
        <?php echo (get_window_title($title)) ?>
    </title>
    <style>
        /*KATODO styling*/
    </style>
</head>

<body>
    <header>
        <div>Logo</div>
    </header>
</body>