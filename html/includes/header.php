<?php
include_once('includes/functions.php');
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
        <nav>
            <?php
            if (isset($_SESSION['role']) && $_SESSION['role'] == "subscriber") {
                include('includes/menu_subscriber.php');
            } else if (isset($_SESSION['role']) && $_SESSION['role'] == "customer") {
                include('includes/menu_customer.php');
            } else {
                include('includes/menu_guest.php');
            }
            ?>
        </nav>
    </header>
</body>