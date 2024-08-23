<?php 
$hostname = "localhost";
$username = "u899862829_sample";
$password = "Sample2023";
$dbName = "u899862829_sample";

$conn = mysqli_connect($hostname, $username, $password, $dbName);
if(!$conn){
    echo "Something went wrong.";
}
?>