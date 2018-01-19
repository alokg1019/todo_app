<?php

if(!isset($_SESSION)){
    session_start();
}

require_once "./../helper/config.php";
require_once "./../helper/helper.php";


if(isset($_POST['create']) && isset($_POST['list_id']) && !empty($_POST['list_id'])){

    $task = $_POST['task'];
    $list_id = $_POST['list_id'];
    unset($_POST);
    $result = add_task($task,$list_id,'N');
}


require_once("./../views/header.php");
require_once("./../views/create_task.php");
require_once("./../views/footer.php");
?>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

