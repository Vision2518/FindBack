<?php
include 'header.php';
?>
<html>
    <head>
        <title>Register-FindBack</title>
        <h1>Register for FindBack </h1>
    </head>
    <body>
        <form action="register.php" method="POST">
            <label for="name">Full Name</label>
            <br>
            <input type="text" id="name" name="name" required><br><br>
           <label for="email">Email:</label> 
        <br><input type="text" id="email" name="email" required><br> <br> 
        <label for="password">Password:</label><br>
        <input  type="password" name="password" id="password" required><br><br> 
          <label for="name">Mobile Number:</label>
            <br>
            <input type="text" id="phone" name="phone" required><br><br>
            <button type="submit" >Register</button>
            <p>Already  have an account?<a href="login.php">Login here</a></p><br>
        </form>
    </body>
    <?php include 'footer.php';?>
</html>