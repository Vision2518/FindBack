<?php
include 'db_connect.php';
if($_SERVER['REQUEST_METHOD']==='POST')
{
    $email=$_POST['email'];
    $otp=$_POST['otp'];
    $sql="SELECT *FROM users WHERE email='$email' AND otp='$otp'";
    $result=mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)===1)
    {
        $sql="UPDATE users SET is_verified=1 WHERE email='$email'";
        if($conn->query($sql)===TRUE)
        {
            echo "Your account is now verified!";
            header("location:homepage.html");
            exit();
        }
    }
    else
    {
        echo "Invalid OTP or email.";
    }
}
?>
<form method="POST">
    <input type="email" name="email" required placeholder="Email"><br>
    <input type="text" name="otp" required placeholder="Enter Otp"><br>
    <button type="submit">Verify</button>
</form>