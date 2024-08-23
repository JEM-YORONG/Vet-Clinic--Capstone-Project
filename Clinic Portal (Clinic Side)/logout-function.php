<?php
require "database-conn.php";
require 'timezone.php';

$query = "SELECT * FROM login WHERE id = '1'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);

$dateAndTime = new DateTime();
$date = $dateAndTime->format('Y-m-d');
$time = $dateAndTime->format('g:i A');

$role = $row['role'];
$username = $row['user'];

$action = "Logout.";

$logs = "INSERT INTO logs (date, time, role, user, action) VALUES ('$date', '$time', '$role', '$username', '$action')";
mysqli_query($conn, $logs);
mysqli_close($conn);

require 'index.php';