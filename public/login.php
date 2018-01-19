<?php
require_once "./../helper/config.php";
require_once "./../helper/helper.php";

if(is_logged_in()){

    header("Location: adduser.php");
}

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = verify_password($email,$password);

    if($result){
        header("Location: adduser.php");
    }else{

        $error = "Password and Email doesn't match";

    }


}


require_once("./../views/header.php");


?>


    <div class="container">
        <div class="row">
            <div class="col-md-offset-5 col-md-3">
                <form action="" method="post">
                    <div class="form-login">
                        <h4>Todo List App.</h4>
                        <input type="text" name="email" id="email" class="form-control input-sm chat-input"
                               placeholder="Email"/>
                        </br>
                        <input type="password" name="password" id="password" class="form-control input-sm chat-input"
                               placeholder="Password"/>
                        </br>
                        <div class="wrapper">
            <span class="group-btn">
                <button type="submit" href="#" name="login" class="btn btn-primary btn-md">Login <i class="fa fa-sign-in"></i></button>
            </span>
                        </div>
                    </div>


                    <?php

                    if(isset($error)){

                        print <<< HTML

                         <div class="wrapper" style="margin-top:10px; ">
                        <div class="alert alert-danger" role="alert">

                            $error
                           
                        </div>
                    </div>
                        
HTML;


                    }


                    ?>




                </form>

            </div>
        </div>
    </div>

<?php
require_once("./../views/footer.php");

?>