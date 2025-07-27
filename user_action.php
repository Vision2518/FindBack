<?php
include 'db_connect.php';
session_start();
$action=$_GET['action']??'';
$id=intval($_GET['id'])?? 0;
//delete
if($action==='delete'&&$id){
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location:manage_users.php");
    exit();
}
//fetch edit
if($action==='edit'&&$id){
    $result=$conn->query("SELECT* FROM users WHERE id=$id");
    $user=$result->fetch_assoc();
}
if($_SERVER['REQUEST_METHOD']==='POST'&& isset($_POST['update_user']))
{
    $id=intval($_POST['id']);
    $name=htmlspecialchars($_POST['name']);
    $email=htmlspecialchars($_POST['email']);
    $phone=htmlspecialchars($_POST['phone']);
    $conn->query("UPDATE users SET name='$name',email='$email',phone='$phone' WHERE id=$id");
    header("Location:manage_users.php");
    exit();
}
?>
<!--Edit form-->
<?php if($action==='edit' && $user):?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit User</title>
    </head>
    <body>
        <h2>Edit User</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?=$user['id']?>">
            <label>Name: <input type="text" name="name" value="<?=$user['name']?>"></label><br><br>
            <label>Email: <input type="email" name="email" value="<?=$user['email']?>"></label><br><br>
            <label>Phone: <input type="text" name="phone" value="<?=$user['phone']?>"></label><br><br>
            <input type="submit"  name="update_user" value="Update">
        </form>
    </body>
    </html>
    <?php endif;?>