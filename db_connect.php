<?php
$server="localhost";
$user="root";
$password="";
$dbname="findback_db";
$conn=new mysqli($server,$user,$password,$dbname);
if($conn->connect_error)
{
   die("connection failed".$conn->connect_error);
}
?>