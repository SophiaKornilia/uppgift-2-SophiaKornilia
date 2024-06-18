<?php
session_start();
session_unset();
session_destroy();
header('Location: successfully_signed_out.php');
exit;
