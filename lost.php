<?php
include 'db_connect.php'; 
if ($_SERVER["REQUEST_METHOD"]=="POST")
{$name=$_POST["name"];
     $item=$_POST["item_name"];
     $date=$_POST["lost_date"];
    $desc=$_POST["item_description"];
    $phone=$_POST["contact_info"];
    $location=$_POST["location"];
       $sql="INSERT INTO lost_items(item_name,description,date_lost,reporter_contact,location,reporter_name) VALUES('$item','$desc','$date','$location','$phone','$name')";
       if($conn->query($sql)===TRUE)
       {
        $last_id=$conn->insert_id;
        echo"<h3>Lost item reported sucessfully!</h3>";
        echo"<a href='cony.php?id=$last_id'>
        <button>🎁Declare Reward(Optional)</button>
        </a><br><br>";
       
       }
       else
       {
        echo "Error".$sql."<br>".$conn->error;
       }
        $conn->close();
}
        else{
        echo "Invaid Request!"; }
?> 