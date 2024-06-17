<?php
session_start();
$_SESSION['isloggedin'] = true;

function get_window_title($title)
{
    return $title . ' - My awesome site';
}
//tar emot en kund eller prenumerant, $role innehåller alltså något av dessa. 
function user_has_role($role)
{
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

function is_signed_in()
{
    return isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true;
    
}

function is_signed_out()
{
    if (isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true) {
        session_unset();
        session_destroy();
        echo '<meta http-equiv="refresh" content="3;url=login.php">';
        exit;
    }
}

function require_role($role){
    if(!is_signed_in() || !user_has_role($role)){
        header('Location: /no-access.php');
        exit();
    }
}