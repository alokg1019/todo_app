<?php


require_once("../../helper/helper.php");

/*
 *     Login checks can be added here, to allow only the logged in user to access this page.
 *     Not adding the check here for simplicity
 */

if(isset($_POST['task']))
{
    $task_list = $_POST['task'];
    $status = true;

    $response = array();

    foreach ($task_list as $task_id)
    {
        $status = complete_task($task_id);
    }


    $response['status'] = 'success';
    $response['message'] = "Tasks completed";

    echo json_encode($response);
    exit();

}