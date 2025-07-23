
<?php
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
     $item=$_POST["item_name"];
     $date=$_POST["found_date"];
    $desc=$_POST["item_description"];
        $phone=$_POST["contact_info"];
        $location=$_POST["location"];
        $line="Item name:".$item."|Found date:".$date."|Location:".$location."|Description:".$desc."|Contact Info:".$phone."\n";
        $file=fopen("found_items.txt","a");
        fwrite($file,$line);
        fclose($file);
        echo"Thank You For Reporting!";
        echo "<h3>Founded item reported sucessfully!</h3>";
        echo "<a href='found_report.html'>Report Another</a>";
        echo "<a href='homepage.html'>Go Home</a>";
}
        else{
        echo "Invaid Request!"; }
?>