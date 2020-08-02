<?php
 
 require_once "connection.php";
 
 $conn = new mysqli($host,$db_user,$db_password,$db_name);
 
 if($conn->connect_error) {
     die("Connection Failed! ".$conn->connect_error);
 }