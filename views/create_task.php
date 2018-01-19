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
        require_once "sidenav.php";
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Create New Task</h1>

            <form class="form-horizontal" method="post">
                <fieldset>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label">Task Name</label>
                        <div class="col-md-4">
                            <input id="task" name="task" type="text" placeholder="task description"
                                   class="form-control input-md" required="">
                        </div>
                    </div>

                    <?php

                        $list_id = $_GET['id'];
                    ?>
                    <input id="list_id" name="list_id" type="hidden" value="<?php echo $list_id ?>">

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="button1id"></label>
                        <div class="col-md-8">
                            <button id="button1id" name="create" class="btn btn-success">CREATE</button>
                            <button id="button2id" name="cancel" type="reset" class="btn btn-danger">CANCEL</button>
                        </div>
                    </div>

                    <?php

                    if(isset($result)){

                        if($result['status']=="error"){

                            $message = $result['message'];

                            print <<< E

                             <div class="form-group">
                                <label class="col-md-4 control-label" for="button1id"></label>
                                <div class="col-md-4">
                                <div class="alert alert-danger" role="alert">
                                   $message
                                   
                                </div>
                                </div>
                            </div>

E;


                        }else{
                            $message = $result['message'];

                            print <<< E

                             <div class="form-group">
                                <label class="col-md-4 control-label" for="button1id"></label>
                                <div class="col-md-4">
                                <div class="alert alert-success" role="alert">
                                   $message
                                   
                                </div>
                                </div>
                            </div>

E;
                        }

                    }

                    ?>


                </fieldset>
            </form>
            <h1 class="page-header">Existing Tasks</h1>
            <?php

            $email = $_SESSION['user_email'];
            $all_tasks = get_my_given_tasks($email);
            $all_html = "";

            //var_dump($all_tasks);

            if(!is_array($all_tasks)){

                $all_html = "No Tasks found.";

            }else{


                $all_html = <<< TABLE
                  <table class="table table-striped">
         
                 <thead>
                    <tr>
                        <th>ID</th>
                        <th>Task</th>
                        <th>List Id</th>
                        <th>Given to</th>
                        <th>Complete</th>
                    </tr>
                    </thead>
                    <tbody>

TABLE;


                foreach ($all_tasks as $task){

                    $task_id = $task['task_id'];
                    $task_desc = $task['task'];
                    $list_id = $task['list_id'];
                    $given_to = $task['buddy_id'];
                    $complete_stat = $task['complete'];

                    $complete = "No";
                    if($complete_stat == "Y")
                    {
                        $complete = "Yes";
                    }



                    $all_html .= <<< HTML
                        
                      <tr>
                        <td>$task_id</td>
                        <td>$task_desc</td>
                        <td>$list_id</td>
                        <td>$given_to</td>
                        <td>$complete</td>
                    </tr>
HTML;
                }


                $all_html .= "</tbody></table>";


            }

            ?>



            <div class="table-responsive">
                <?php

                echo $all_html;

                ?>
            </div>

        </div>

    </div>
</div>