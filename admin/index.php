<?php
include_once '../backend/config.php';
include_once '../header.php';
include_once 'adminheader.php';

?>
<h1>Welcome back, <?php echo $_SESSION['u_uid'];?></h1>
<?php
//-----[see checkins for current event]-----
//today is...
$currentDay = date("Y-m-d");
$currentTime = date("h:i:s");
$CurrentTimestamp = $currentDay.' '.$currentTime; //yay sql formatting!

//grab most current events

//Wow i need to do this every time???
$currentDay = date("Y-m-d");
$currentTime = date("h:i:s");
$CurrentTimestamp = $currentDay.' '.$currentTime; //yay sql formatting!

//calling it func2 because i dont want to confuse the values from the auth 
$sql2 = "SELECT * FROM eventlist where (start_time < '$CurrentTimestamp') and ('$CurrentTimestamp' < end_time)";
$query2 = mysqli_query($conn, $sql2);
$result2 = mysqli_num_rows($query2);
if ($result2 > 0) {
    while($row = mysqli_fetch_assoc($query2)) {
        $sql3 = "SELECT * FROM master_record WHERE (event_name='$row[event_name]')";
        $query3 = mysqli_query($conn, $sql3);
        $result3 = mysqli_num_rows($query3);
        echo "<div class='alert alert-primary' role='alert'>".$result3." people have checked into your current event: <i>".$row['event_name']."</i>. Check it out <a href='https://aws.azureagst.pw/points/admin/masterrecord.php'>on the MCR</a>!</div><br>";
    }
}

//-----[See if any event hasnt been ported]-----
$sql = "SELECT * FROM eventlist WHERE ('$CurrentTimestamp' > end_time)";
$result = mysqli_query($conn, $sql);
$row = mysqli_num_rows($result);

if ($row > 0) {
    echo "<div class='alert alert-warning' role='alert'>You have ".$row." event(s) that haven't been reviewed yet!</div><br>";    
}
?>

<br>

<!-- USER LIST -->
<h2>User List</h2>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>House</th>
            <th>Points</th>
        </tr>
        </thead>
        <tbody>
        <?php
        //calling it func2 because i dont want to confuse the values from the auth 
        $sql2 = "SELECT * FROM users";
        $query2 = mysqli_query($conn, $sql2);
        $result2 = mysqli_num_rows($query2);
        if ($result2 > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($query2)) {
                echo '<tr><th>'.$row["u_id"].'</th><td>'.$row["u_firstname"].' '.$row["u_lastname"].'</td><td>'.$row["u_email"].'</td><td>'.$row["u_house"].'</td><td>'.$row["u_points"].'</td></tr>';           
            }
        } else {
            echo "<tr><th>N/A</th><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<?php
include_once 'adminfooter.php';
?>