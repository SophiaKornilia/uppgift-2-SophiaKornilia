<?php
include_once('functions.php');
?>
<html>
    <head>
        <title>
            <?php echo(get_window_title($title))?>
        </title>
        <style>
            /*KATODO styling*/
        </style>
    </head>
    <body>
        <header>
            <div>Logo</div>
            <?php
         //KATODO gör en ifsats
            include('includes/menu_guest.php');
       
            // include('includes/menu_subscriber.php');
     
            // include('includes/menu_customer.php');
   
            ?>
        </header>
    </body>