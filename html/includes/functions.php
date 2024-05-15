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
    if ($role === 'customer') {
        return true;
    } else {
        return false;
    }
}
function is_signed_in()
{
    if ($_SESSION['isloggedin'] === true) {
        return true;
    } else {
        return false;
    }
}

function is_signed_out(){
    if ($_SESSION['isloggedin'] === true) {
        session_unset();
        header('Location:logout.php');
    }  
}