<?php
include 'db_connect.php';
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $hashed_password=password_hash($password,PASSWORD_DEFAULT);
    $sql="INSERT INTO users(name,email,Password) VALUES('$name','$email','$hashed_password')";
    if($conn->query($sql)===TRUE)
    {
        echo "Registration sucessful! <a href='login.html'>Login here</a>";
    }
    else
        echo "Error:".$sql."<br>".$conn.error;
    $conn->close();

}
echo "Invalid Request";
?>