<?php
include 'db_connect.php';
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $hashed_password=password_hash($password,PASSWORD_DEFAULT);
    $otp=rand(100000,999999);
    //save user
    $sql="INSERT INTO users(name,email,Password,otp) VALUES('$name','$email','$hashed_password','$otp')";
    if($conn->query($sql)===TRUE)
    {//later sms will be used
        echo "Registration sucessful! Your OTP is: $otp";
        echo "<br><a href='verify.php'>Click To Verify</a>";
    }
    else
        echo "Error:".$sql."<br>".$conn.error;
    $conn->close();
}
?>