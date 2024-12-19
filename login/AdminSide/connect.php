<?php

/*$host="localhost";
$user="root";
$pass="";
$db="login";*/

$host="localhost";
$user="u143688490_lou";
$pass="Fujwiara000!";
$db="u143688490_websiteee"; 

$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){
    echo "Failed to connect DB".$conn->connect_error;
}
?>
