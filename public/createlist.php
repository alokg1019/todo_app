<?php

if(!isset($_SESSION)){
    session_start();
}

require_once "./../helper/config.php";
require_once "./../helper/helper.php";

if(!is_logged_in())
{
    header("Location: login.php");
    exit();
}


if(isset($_POST['create'])){


    $email = $_POST['email'];
    $list = $_POST['list'];

    $result = create_list($email,$list);



}


require_once("./../views/header.php");
require_once("./../views/createlist.php");
require_once("./../views/footer.php");

?>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

