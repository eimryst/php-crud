<?php
    $server     ="localhost";
    $username   ="root";
    $password   ="";
    $database   ="car dealer";
    $port       ="3306";

    $conCD    = mysqli_connect($server, $username, $password, $database, $port);

    if($conCD -> connect_error){
        die ("Connection Error, Check Database Credentials.".$conCD->connect_error);
    }
    else {
        // echo "Connection success!";
    }

?>