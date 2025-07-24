<?php
include 'db_connect.php';
if($_SERVER['REQUEST_METHOD']==='POST')
{
    $item_id=intval($_POST['item_id']);
    $reward=floatval($_POST['reward']);
    if($reward>=0)
    {
        $sql="UPDATE lost_items SET reward_amount=$reward WHERE id=$item_id";
        if($conn->query($sql)===TRUE)
        {

            echo "✅ Reward of Rs. $reward saved successfully!";
        } else {
            echo "❌ Error saving reward: " . $conn->error;
        }
        }else{
            echo "Invalid input!";
        }
        echo"<br><a href='homepage.html'>Go Home</a>";
        exit();
    }
    
   if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $item_id = intval($_GET['id']);
    ?>
    <form method="POST">
        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
        <label>Declare Reward (Optional):</label>
        <input type="number" name="reward" step="10" min="0" placeholder="Enter reward amount">
        <button type="submit">Set Reward</button>
    </form>
    <?php
} else {
    echo "<p>Invalid request. No item ID provided.</p>";
    echo "<a href='homepage.html'>Go Home</a>";
}
?>