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
        echo "Data inserted sucessfully";
       }
       else
       {
        echo "Error".$sql."<br>".$conn->error;
       }
       $conn->close();
        echo "<h3>Lost item reported sucessfully!</h3>";
        echo "<br>"."want to declare reward";
        echo "<a href='lost_report.html'>Report Another</a>";
        echo "<a href='homepage.html'>Go Home</a>";
}
        else{
        echo "Invaid Request!"; }
?>