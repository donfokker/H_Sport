
<?php
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "database_name"; // edit this

    if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)){
        die("failed to connect");
    }
?>