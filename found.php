
<?php
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
        $name=$_POST["name"];
     $item=$_POST["item_name"];
     $date=$_POST["found_date"];
    $desc=$_POST["item_description"];
        $phone=$_POST["contact_info"];
        $location=$_POST["location"];
      $sql="INSERT INTO found_items (item_name,description,date_found,location,reporter_name,reporter_contact) VALUES ('$item','$desc','$date_found',$location','$name','$phone')";
     if($conn->query($sql)===TRUE)
     {
          echo"Thank You For Reporting!";
        echo "<h3>Founded item reported sucessfully!</h3>";
         echo "<a href='report_lost.php'><button>➕ Report Another</a>";
        echo "<a href='homepage.html'><button>🏠 Go Home</button></a>";
     }
     else
     {
        echo "Error:".$sql."<br>".$conn->error;
     }
}
     else
        echo "Invaid Request!";
?>