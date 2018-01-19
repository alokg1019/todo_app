<?php

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
//if user is logged in ,logs him out
    $_SESSION = array();

    //frees all the session variables currently registered
    session_unset();
    session_destroy();

    header("Location:login.php");
} else {

//if user tries to access this without logging in, redirect to login.php
    header("Location:login.php");

}

?>