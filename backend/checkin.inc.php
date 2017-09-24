<?php 
session_start();

////////////////////////////////////////
//                                    //
//          checkin.inc.php           //
//        By: Andrew Augustine        //
//                                    //
////////////////////////////////////////

//
// This is gonna fuckin suck:
//
//1. Grab User Variables -> (u_id, u_firstname, u_lastname, u_uid, u_house, u_points)
//2. Verify User Credentials
//3. Grab Event Variables -> (event_name, start_time, end_time, ?house?)
//4. Make sure user hasn't checked in already
//5. Hella Math -> (figure out new point total, etc.)
//6. Submit Points earned to Master Record -> (u_id, event_name, timestamp, points_earned)
//7. Submit points to temporary tally by house -> (INSERT INTO temp ($u_house) VALUES $points_earned; WHERE (u_house=$u_house)AND (id=0);)
//8. Add points earned to user's total point value -> (INSERT INTO temp (u_points) VALUES ($points_earned) WHERE u_id=$_id)
//
// may god have mercy on my soul
// you can bet your ass i'm gonna be heavily annotating this one.
//
//--[Start Script]------------------------------------------------------------------------------------------------------------------------

//prevent users from seeing the source code for exploiting, make sure the submit button was pressed
if (isset($_POST['submit'])) { 

    //--[Part 1]--------------------------------------------------------------------------------------------------------------------------

    //initiate database connection
    include_once 'config.php';
    echo "<p>Config Initiated...</p>";

    //get vars from form
    $firstname = mysqli_real_escape_string($conn, $_POST['u_firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['u_lastname']);
    $house = mysqli_real_escape_string($conn, $_POST['u_house']);
    $event = mysqli_real_escape_string($conn, $_POST['select_event']);
    echo "<p>Vars from form: $firstname, $lastname, $house, $event </p>";

    //check for empty
    if (empty($firstname) || empty($lastname) || empty($house)) {
        header("Location: ../checkin.php?error=empty_field");
        exit();
    }

    if ($event === 'na') {
        header("Location: ../checkin.php?error=no_event");
        exit();
    } 

    //grab server-side vars for user
    $sql = "SELECT * FROM users WHERE u_firstname='$firstname' and u_lastname='$lastname';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);

    //--[Part 1.1]------------------------------------------------------------------------------------------------------------------------

    //does user exist?
    //if ($resultCheck === 0) {
        //let's create a user then

        // //today is...
        // $currentDay = date("Y-m-d");
        // $currentTime = date("h:i:s");
        // $CurrentTimestamp = $currentDay.' '.$currentTime; //yay sql formatting!
        // echo "<p>Date: $CurrentTimestamp </p>";
        // //grab server-side vars for current event
        // $sql = "SELECT * FROM eventlist WHERE (start_time < '$CurrentTimestamp' < end_time) and (event_name = '$event');";
        // $result = mysqli_query($conn, $sql);
        // $resultCheck = mysqli_num_rows($result);
        // $row = mysqli_fetch_assoc($result);
        // //similar to the last set, let's convert these to PHP
        // $event_name = $row['event_name'];
        // $start_time = $row['start_time'];
        // $end_time = $row['end_time'];
        // $point_value = $row['point_worth'];
        // $aquinas_pts = $row['Aquinas'];
        // $augustine_pts = $row['Augustine'];
        // $bonaventure_pts = $row['Bonaventure'];
        // $hildegard_pts = $row['Hildegard'];

        // $insertcmd = "INSERT INTO users (u_firstname, u_lastname, u_email, u_uid, u_type, u_house, u_points) VALUES ('$firstname','$lastname','needstosignup@jpiichs.org', 'noUser', 1, '$house', '$point_value');";
        // echo $insertcmd;
        // mysqli_query($conn, $insertcmd);

        //header("Location: ../checkin.php?signup=$firstname");
        //exit();
    //} //else, continue

    //--[Part 1 cont.]--------------------------------------------------------------------------------------------------------------------

    //convert server-side vars from MySQL Array to PHP Variables to use in script
    $server_id = $row['u_id'];
    $server_firstname = $row['u_firstname'];
    $server_lastname = $row['u_lastname'];
    $server_uid = $row['u_uid'];
    $server_house = $row['u_house'];
    $server_points = $row['u_points'];
    echo "<p>Vars from server: $server_firstname, $server_lastname, $server_house </p>";

    //--[Part 2]--------------------------------------------------------------------------------------------------------------------------

    //let's check!

    //did no users meet the data in the query?
    if ($resultCheck === 0) { 
        //no? then there must be no user in the database for them.
        header("Location: ../checkin.php?error=no_user"); 
        exit();
    //does the house on server records meet the one they inputted?
    } elseif ($server_house !== $house) {
        //no? then the input was wrong.
        header("Location: ../checkin.php?error=false_house");
        exit();
    } //if those returned as false, then the user put their data in correctly. verification passed!

    //--[Part 3]--------------------------------------------------------------------------------------------------------------------------

    //today is...
    $currentDay = date("Y-m-d");
    $currentTime = date("h:i:s");
    $CurrentTimestamp = $currentDay.' '.$currentTime; //yay sql formatting!
    echo "<p>Date: $CurrentTimestamp </p>";

    //grab server-side vars for current event
    $sql = "SELECT * FROM eventlist WHERE (start_time < '$CurrentTimestamp' < end_time) and (event_name = '$event');";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);

    //similar to the last set, let's convert these to PHP
    $event_name = $row['event_name'];
    $start_time = $row['start_time'];
    $end_time = $row['end_time'];
    $point_value = $row['point_worth'];
    $aquinas_pts = $row['Aquinas'];
    $augustine_pts = $row['Augustine'];
    $bonaventure_pts = $row['Bonaventure'];
    $hildegard_pts = $row['Hildegard'];

    echo "<p>Event: $event_name, $start_time, $end_time, $point_value </p>";

    //--[Part 4]--------------------------------------------------------------------------------------------------------------------------

    //grab server-side vars for current event
    $sql = "SELECT * FROM master_record WHERE ('$event_name' = event_name) and ('$server_id' = user_id);";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    $current_team_pts = $row[$server_house];


    //have they checked in?
    if ($resultCheck > 0) {
        //yes? return error.
        header("Location: ../checkin.php?error=already_here");
        exit();
    }

    echo "<p> user is not checked in already </p>";

    //--[Part 5]--------------------------------------------------------------------------------------------------------------------------

    //add point worth to current student's point value
    $newPoints = $server_points + $point_value;
    echo "<p>newpoints = $newPoints </p>";

    //add points earned to team tally
    $newTeamPoints = $current_team_pts + $point_value;
    echo "<p>teamnewpoints = $newTeamPoints </p>";

    //--[Part 6]--------------------------------------------------------------------------------------------------------------------------

    //add checkin to master_record
    $sql = "INSERT INTO master_record (user_id, event_name, points_earned) VALUES ('$server_id', '$event_name', '$point_value');";
    $result = mysqli_query($conn, $sql);
    echo "<p>checkin added to master record</p>";

    //--[Part 7]--------------------------------------------------------------------------------------------------------------------------

    //add point value to tally
    $sql = "UPDATE eventlist SET $server_house='$newTeamPoints' WHERE (event_name='$event_name');";
    $result = mysqli_query($conn, $sql);
    echo "<p>point value added to tally</p>";

    //--[Part 8]--------------------------------------------------------------------------------------------------------------------------

    //add point value to student record
    $sql = "UPDATE users SET u_points='$newPoints' WHERE (u_id = '$server_id');";
    $result = mysqli_query($conn, $sql);
    echo "<p>point value added to student record</p>";

    //--[End Script]--------------------------------------------------------------------------------------------------------------------------
    echo "<p>...and that's all folks!</p>";

    //this one's so long you gotta tell it to leave the page
    header("Location: ../checkin.php?success=$server_firstname");
    exit();
} else {
    header("Location: ../index.php?error=fuck_off");
    exit();
}
?>

<p>loading...</p>