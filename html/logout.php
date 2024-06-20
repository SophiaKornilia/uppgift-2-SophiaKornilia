<?php
session_start();
session_unset();
session_destroy();
$_SESSION['isloggedin'] = false;
header('Location: successfully_signed_out.php');
exit;
