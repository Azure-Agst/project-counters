<?php
include_once '../backend/config.php';
include_once '../header.php';
include_once 'adminheader.php';
?>
<link id="bsdp-css" href="../include/css/bootstrap-datepicker3.min.css" rel="stylesheet">
<div class="container">
    <?php
    if ($_SERVER["QUERY_STRING"] === "error=empty") {
        echo '<div class="alert alert-danger" role="alert">Woah something was empty!</div><br>';
    } elseif ($_SERVER["QUERY_STRING"] === "error=invalid_date") { 
        echo '<div class="alert alert-danger" role="alert">Date format was not valid! Make sure it follows [YYYY-MM-DD hh:mm:ss] where hh:mm:ss is the time in 24-hour time.</div><br>';
    } elseif ($_SERVER["QUERY_STRING"] === "error=already_exists") {
        echo '<div class="alert alert-danger" role="alert">That event already exists.</div><br>';
    } elseif ($_GET['success'] !== null) {
        echo '<div class="alert alert-success" role="alert">Event '.$_GET['success'].' was created!</div><br>';
    }
    ?>
    <h3>Upcoming Events</h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Event Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Point Worth</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //today is...
            $currentDay = date("Y-m-d");
            $currentTime = date("h:i:s");
            $CurrentTimestamp = $currentDay.' '.$currentTime; //yay sql formatting!

            //calling it func2 because i dont want to confuse the values from the auth 
            $sql2 = "SELECT * FROM eventlist where (start_time > '$CurrentTimestamp');";
            $query2 = mysqli_query($conn, $sql2);
            $result2 = mysqli_num_rows($query2);
            if ($result2 > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($query2)) {
                    echo '<tr><th>'.$row["event_name"].'</th><td>'.$row["start_time"].'</td><td>'.$row["end_time"].'</td><td>'.$row["point_worth"].'</td></tr>';           
                }
            } else {
                echo "<tr><th>N/A</th><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    <hr>
    <h4>Current Events</h4>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Event Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Point Worth</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //Wow i need to do this every time???
            $currentDay = date("Y-m-d");
            $currentTime = date("h:i:s");
            $CurrentTimestamp = $currentDay.' '.$currentTime; //yay sql formatting!
            //calling it func2 because i dont want to confuse the values from the auth 
            $sql2 = "SELECT * FROM eventlist where (start_time < '$CurrentTimestamp') and ('$CurrentTimestamp' < end_time)";
            $query2 = mysqli_query($conn, $sql2);
            $result2 = mysqli_num_rows($query2);
            if ($result2 > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($query2)) {
                    echo '<tr><th>'.$row["event_name"].'</th><td>'.$row["start_time"].'</td><td>'.$row["end_time"].'</td><td>'.$row["point_worth"].'</td></tr>';           
                }
            } else {
                echo "<tr><th>N/A</th><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    <hr>
    <h4>Create Event</h4>
    <hr>
    <form action="../backend/create.inc.php" method="POST">
        <label for="ename">Event Name:</label>
        <input type="text" class="form-control" name="event_name" id="ename" placeholder="Event Name" >
        <div class="row">
            <div class="col">
                <label for="start_time">Start Time:</label>
                <input type="timestamp" class="form-control" name="start_time" id="start_time" placeholder="YYYY-MM-DD hh:mm:ss" >
            </div>
            <div class="col">
                <label for="end_time">End Time:</label>
                <input type="timestamp" class="form-control" name="end_time" id="end_time" placeholder="YYYY-MM-DD hh:mm:ss">
            </div>
        </div>
        <label for="ptval">Point Value:</label>
        <input type="number" class="form-control" name="point_value" id="ptval" placeholder="Point Worth" >
        <hr>
        <button name="submit" class="btn btn-outline-warning my-2 my-sm-0 float-right">Create Event</button>
    </form>
</div>
<script>
$('#sandbox-container input').datepicker({
    format: "12/06/2019",
    clearBtn: true
});
</script>
<script src="../include/js/bootstrap-datepicker.min.js"></script>
<script src="../include/locales/bootstrap-datepicker.en-GB.min.js" charset="UTF-8"></script>
<?php
include_once 'adminfooter.php'
?>