<?php

require_once("config.php");


/*connects to db*/
function dbConnect()
{
  $con = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASS,DB_NAME);
  if(mysqli_connect_errno())
   {
     die("Could not connect to Database"); 
   }
  return $con;
}

/*close the connection*/
function dbClose($con)
{
  mysqli_close($con);
}


function cleanMysql($c,$s)
{
  return mysqli_real_escape_string($c,$s);
}

function trimS($s,$size)
{
  return substr($s,0,$size);
}


function user_exits($email)
{
  $con = dbConnect();
  $email = cleanMysql($con,$email);
  $q = "SELECT id FROM ".DB_NAME.".users WHERE email_id = '$email'";

  if($qf = mysqli_query($con,$q))
  {
    $numr = mysqli_num_rows($qf);
    if($numr>0)
    {
      $res = mysqli_fetch_array($qf);
      $t = $res['id'];
      return $t;
    }
    else
     {
       dbClose($con);
       return false;
     }
  }
  else
  {
    dbClose($con);
    return false;
  }

  dbClose($con);
  return false;
}

function is_logged_in()
{
    if(!isset($_SESSION))
    {
        session_start(); // don't create a new session
    }

    if(isset($_SESSION['user_id']))
    {
        $user_id = $_SESSION['user_id'];
        return $user_id;
    }

    //return false if session not set
    return false;
}

function verify_password($email,$password)
{
    $con = dbConnect();
    $email = cleanMysql($con,$email);
    $password = cleanMysql($con,$password);

    $query = "SELECT * FROM ".DB_NAME.".users WHERE email_id = '$email'";

    if($result = mysqli_query($con,$query))
    {
        $numr = mysqli_num_rows($result);
        if($numr > 0)
        {
            //fetch result row
            $row = mysqli_fetch_array($result);
            $p_hash = $row['password'];


            if(password_verify($password,$p_hash))
            {

                $user_email = $row['email_id'];
                $admin = $row['admin'];
                $user_id = $row['id'];
                $name = $row['names'];

                if(!isset($_SESSION))
                {
                    session_start();
                }

                $_SESSION['user_email'] = $user_email;
                $_SESSION['admin'] = $admin;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['name'] = $name;

                return true;
            }

        }
        else
        {
            dbClose($con);
            return false;
        }
    }
    else
    {
        dbClose($con);
        return false;
    }

    dbClose($con);
    return false;
}

function login($email,$pasword)
{

    if(verify_password($email,$pasword))
    {
        return true;
    }

    return false;
}

function add_user($email,$name,$password,$admin = 'N')
{

    $response = array();
    if(user_exits($email))
    {

        $response['status'] = 'error';
        $response['message'] = "User already exists";
        return $response;
    }

    //try adding the user to the database
    $con = dbConnect();
    $email = cleanMysql($con,$email);
    $name = cleanMysql($con,$name);
    $password = cleanMysql($con,$password);
    $password = password_hash($password,PASSWORD_BCRYPT);

    if($admin != "Y" || $admin !="N")
    {
        $admin = "N";
    }

    $email = cleanMysql($con,$email);
    $insert_query = "INSERT INTO ".DB_NAME.".users (email_id,password,names,admin) VALUES ('$email','$password','$name','$admin')";

   // var_dump($insert_query);

    $result = mysqli_query($con,$insert_query);

    if($result === false)
    {
        $response['status'] = 'error';
        $response['message'] = "Error adding user.";
        return $response;
    }

    $response['status'] = 'success';
    $response['message'] = 'User added successfully';

    return $response;

}

function create_list($buddy_email,$list_name)
{

    $response = array();

    //try adding the task to the database
    $con = dbConnect();
    $user_id = cleanMysql($con,$_SESSION['user_id']);
    $buddy_id = user_exits($buddy_email);

    if($buddy_id === false){

        $response['status'] = 'error';
        $response['message'] = "Buddy doesn't Exists";
        return $response;

    }

    $buddy_id = cleanMysql($con,$buddy_id);


    if($user_id === $buddy_id){

        $response['status'] = 'error';
        $response['message'] = "Cannot create list for self";
        return $response;


    }


    $list_name = cleanMysql($con,$list_name);

    $insert_query = "INSERT INTO ".DB_NAME.".buddy_list (user_id,buddy_id,list_name) VALUES ('$user_id','$buddy_id','$list_name')";
    $result = mysqli_query($con,$insert_query);

    if($result === false)
    {
        $response['status'] = 'error';
        $response['message'] = "Error creating list.";
        return $response;
    }

    $response['status'] = 'success';
    $response['message'] = 'List created successfully';

    return $response;
}

function add_task($task,$list_id,$complete = 'N')
{
    $response = array();

    //try adding the task to the database
    $con = dbConnect();
    $task = cleanMysql($con,$task);
    $list_id = cleanMysql($con,$list_id);

    if($complete != "Y" || $complete !="N")
    {
        $complete = "N";
    }

    $insert_query = "INSERT INTO ".DB_NAME.".tasks (task,list_id,complete) VALUES ('$task','$list_id','$complete')";
    $result = mysqli_query($con,$insert_query);

    if($result === false)
    {
        $response['status'] = 'error';
        $response['message'] = "Error adding task.";
        return $response;
    }

    $response['status'] = 'success';
    $response['message'] = 'Task added successfully';

    return $response;
}

// tasks given by my buddies, for a given email id
function get_my_pending_task($email)
{
    $response = array();

    $con = dbConnect();
    $email = cleanMysql($con,$email);

    $query = "SELECT u.email_id, b.list_name,b.buddy_id,b.user_id, t.task,t.list_id,t.complete,t.id task_id
FROM users u JOIN buddy_list b ON u.id = b.buddy_id
LEFT OUTER JOIN tasks t ON b.id = t.list_id
WHERE complete = 'N' AND email_id = '$email'";

    $result = mysqli_query($con,$query);

    if($result)
    {
        $numr = mysqli_num_rows($result);
        if($numr > 0)
        {

            while($row = mysqli_fetch_array($result))
            {
                $temp = array();
                $temp['email'] = $row['email_id'];
                $temp['list_name'] = $row['list_name'];
                $temp['buddy_id'] = $row['buddy_id'];
                $temp['user_id'] = $row['user_id'];
                $temp['task'] = $row['task'];
                $temp['list_id'] = $row['list_id'];
                $temp['complete'] = $row['complete'];
                $temp['task_id'] = $row['task_id'];
                array_push($response,$temp);
            }

            return $response;
        }
        else
        {
            dbClose($con);
            return null;
        }

    }

    return null;

}


function get_my_given_tasks($email)
{
    $response = array();

    $con = dbConnect();
    $email = cleanMysql($con,$email);

    $query = "SELECT u.email_id, b.list_name,b.buddy_id,b.user_id,t.task,t.list_id,t.complete,t.id task_id  FROM ". DB_NAME . ".users u JOIN buddy_list b ON u.id = b.user_id JOIN tasks t ON t.list_id = b.id WHERE u.email_id = '$email'";
    $result = mysqli_query($con,$query);

    if($result)
    {
        $numr = mysqli_num_rows($result);
        if($numr > 0)
        {

            while($row = mysqli_fetch_array($result))
            {
                $temp = array();
                $temp['email'] = $row['email_id'];
                $temp['list_name'] = $row['list_name'];
                $temp['buddy_id'] = $row['buddy_id'];
                $temp['user_id'] = $row['user_id'];
                $temp['task'] = $row['task'];
                $temp['list_id'] = $row['list_id'];
                $temp['complete'] = $row['complete'];
                $temp['task_id'] = $row['task_id'];
                array_push($response,$temp);
            }

            return $response;
        }
        else
        {
            dbClose($con);
            return null;
        }

    }

    return null;

}

function complete_task($task_id)
{
    $con = dbConnect();
    $task_id = cleanMysql($con,$task_id);

    $query = "UPDATE ".DB_NAME.".tasks SET complete = 'Y' WHERE id = '$task_id'";
    $result = mysqli_query($con,$query);

    if($result === false)
    {
        return false;
    }

    return true;
}


function getAllUsers(){

    $response = array();

    $con = dbConnect();

    $query = "SELECT *  FROM ". DB_NAME . ".users";
    $result = mysqli_query($con,$query);

    if($result)
    {
        $numr = mysqli_num_rows($result);
        if($numr > 0)
        {

            while($row = mysqli_fetch_array($result))
            {
                $temp = array();
                $temp['id'] = $row['id'];
                $temp['email_id'] = $row['email_id'];
                $temp['names'] = $row['names'];

                array_push($response,$temp);
            }

            return $response;
        }
        else
        {
            dbClose($con);
            return null;
        }

    }

    return null;

}

function getAllList(){

    $response = array();

    $con = dbConnect();

    $query = "SELECT bl.id,u.names as buddy_id,bl.list_name  FROM ". DB_NAME . ".buddy_list bl join users u on u.id = bl.buddy_id";
    $result = mysqli_query($con,$query);

    if($result)
    {
        $numr = mysqli_num_rows($result);
        if($numr > 0)
        {

            while($row = mysqli_fetch_array($result))
            {
                $temp = array();
                $temp['id'] = $row['id'];
                $temp['buddy_id'] = $row['buddy_id'];
                $temp['list_name'] = $row['list_name'];

                array_push($response,$temp);
            }

            return $response;
        }
        else
        {
            dbClose($con);
            return null;
        }

    }

    return null;

}