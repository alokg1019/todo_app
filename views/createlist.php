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
            <h1 class="page-header">Create New List</h1>

            <form class="form-horizontal" method="post">
                <fieldset>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label">Email-ID</label>
                        <div class="col-md-4">
                            <input id="email" name="email" type="text" placeholder="Email ID"
                                   class="form-control input-md" required="">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label">List Name</label>
                        <div class="col-md-4">
                            <input id="list" name="list" type="text" placeholder="List Name"
                                   class="form-control input-md" required="">

                        </div>
                    </div>

                    <!-- Button (Double) -->
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

            <h1 class="page-header">Existing List</h1>

            <?php

            $all_list = getAllList();

            $all_html = "";

            if(!is_array($all_list)){

                $all_html = "No List";

            }else{


                $all_html = <<< TABLE
                  <table class="table table-striped">
         
                 <thead>
                    <tr>
                        <th>ID</th>
                        <th>Buddy Name</th>
                        <th>List Name</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

TABLE;


                foreach ($all_list as $user){

                    $id = $user['id'];
                    $name = $user['buddy_id'];
                    $lname = $user['list_name'];

                    $all_html .= <<< HTML
                        
                      <tr>
                        <td>$id</td>
                        <td>$name</td>
                        <td>$lname</td>
                        <td><a href="create_task.php?id=$id"><button class="btn btn-primary">Add Item</button></a></td>
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

