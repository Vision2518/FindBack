<?php
session_start();
$admin_user="admin";
$admin_pass="1234";
if ($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $user=$_POST['username'];
        $pass=$_POST['password'];
        if($user===$admin_user&&$pass===$admin_pass)
            {
                $_SESSION['loggedin']=true;
                header("location:view_reports.php");
                exit();
                }
        else
            {
                echo "Invalid username or password.";
                }
        }
    else
    {
    header("location:admin_login.html");
exit();
    }
?>