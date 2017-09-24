<?php
include_once '../backend/config.php';
include_once '../header.php';
include_once 'adminheader.php';
?>
<div class="row">
    <div class="col">
        <h2>Master Check-In Record</h2>
    </div>
    <div class="col">
        <p class="text-right">(Arranged with the most recent at the top)</p>
    </div>
</div>

<div class="table-responsive">
<table class="table table-striped">
    <thead>
    <tr>
        <th>Transaction ID</th>
        <th>User Name</th>
        <th>Event Name</th>
        <th>Checked In @</th>
        <th>Points Earned</th>
    </tr>
    </thead>
    <tbody>
    <?php
    //calling it func2 because i dont want to confuse the values from the auth 
    $sql2 = "SELECT * FROM master_record ORDER BY check_time DESC LIMIT 0, 100";
    $query2 = mysqli_query($conn, $sql2);
    $result2 = mysqli_num_rows($query2);

    if ($result2 > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($query2)) {
            //get actual name
            $sql3 = "SELECT * FROM users WHERE (u_id=$row[user_id])";
            $query3 = mysqli_query($conn, $sql3);
            $row2 = mysqli_fetch_assoc($query3);
            echo '<tr><th>'.$row["trans_id"].'</th><td>'.$row2["u_firstname"].' '.$row2["u_lastname"]. '</td><td>'.$row["event_name"].'</td><td>'.$row["check_time"].'</td><td>'.$row["points_earned"].'</td></tr>';           
        }
    } else {
        echo "<tr><th>N/A</th><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
    }
    ?>
    </tbody>
</table>
</div>


<?php
include_once 'adminfooter.php'
?>
