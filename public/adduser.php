<?php
require_once "./../helper/config.php";
require_once "./../helper/helper.php";


if(isset($_POST['create'])){


    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $result = add_user($email,$name,$pass);

    //var_dump($result);



}


require_once("./../views/header.php");
require_once("./../views/adduser.php");
require_once("./../views/footer.php");

?>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
