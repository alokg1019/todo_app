<?php

    require_once("./../helper/helper.php");
    if(!is_logged_in())
    {
        header("Location: login.php");
        exit();
    }

    if(!isset($_SESSION))
    {
        session_start();
    }

//    $email = 'abc@gmail.com';  // dummy
    $email = $_SESSION['user_email'];
    $data = get_my_pending_task($email);


    $pending_list_html = '';
    $total_pending_items = count($data);

    if($total_pending_items > 0)
    {
        foreach ($data as $row)
        {
            if($row['complete'] == "N")
            {
                $task_id = $row['task_id'];
                $task = $row['task'];
                //pending
                $pending_list_html .= <<< LIST
            <li class="ui-state-default" id="task_$task_id">
                <div class="checkbox">
                    <label><input type="checkbox" class="pending_tasks" value="" id="$task_id"/>$task</label>
                </div>
                <div>
                    <label>Temp text</label>
                </div>
            </li>
LIST;
            }
        }
    }
    else
    {

    }


?>
<style>
    .todo-single {

        border: 1px solid lightgray;

    }

    .todo-single > .todo-s-header{

        color: #fff;
        background-color: #428bca;
        padding: 5px;

    }
    .span-given{
        font-size:15px;
        font-weight: bold;
    }
    .span-status-p{
        margin-top: 20px;
    }

    .todolist {
        background-color: #FFF;
        padding: 20px 20px 10px 20px;
        margin-top: 30px;
    }

    .todolist h1 {
        margin: 0;
        padding-bottom: 20px;
        text-align: center;
    }

    .form-control {
        border-radius: 0;
    }

    li.ui-state-default {
        background: #fff;
        border: none;
        border-bottom: 1px solid #ddd;
    }

    li.ui-state-default:last-child {
        border-bottom: none;
    }

    .todo-footer {
        background-color: #F4FCE8;
        margin: 0 -20px -10px -20px;
        padding: 10px 20px;
    }

    #done-items li {
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
        text-decoration: line-through;
    }

    #done-items li:last-child {
        border-bottom: none;
    }

    #checkAll {
        margin-top: 10px;
    }
</style>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="#">Help</a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Search...">
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <?php
                require_once "sidenav.php"
        ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">ToDo List</h1>
            <div class="row todo-single">
                <div class="col-md-12 todo-s-header">

                    <div class="col-md-3"></div>
                    <div class="col-md-12">
                        <h2>Pending Tasks</h2>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="todolist not-done">
                        <button id="checkAll_pending_list" class="btn btn-success">Mark all as done</button>

                        <hr>
                        <ul id="sortable" class="list-unstyled">
                            <?php
                                 echo $pending_list_html;
                            ?>
                        </ul>
                        <div class="todo-footer">
                            <strong><span class="count-todos"><?php echo $total_pending_items ?></span></strong> Items Left
                        </div>

                        <div id="pending_list_error" class="alert alert-danger" role="alert" style="display: none">
                        </div>
                        <div id="pending_list_success" class="alert alert-success" role="alert" style="display: none">
                        </div>
                        <div>
                            <button id="pending_task_save" class="btn btn-primary" style="margin-top: 10px">Save</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

