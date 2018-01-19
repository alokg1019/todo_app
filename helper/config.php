<?php

//$dev_environment = "server";   // server environment
$dev_environment = "local";   // local environment

if ($dev_environment == "local") {
    //database name
    define("DB_NAME", "todo");
    //database password
    define("DB_PASS", "");
    //server name
    define("DB_SERVER", "localhost");
    //username
    define("DB_USERNAME", "root");
}

?>