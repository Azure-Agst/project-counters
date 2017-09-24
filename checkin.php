<?php
    include_once 'header.php';
    include_once './backend/config.php';

    //server side auth
    $sql = "SELECT * FROM users WHERE u_uid='$_SESSION[u_uid]';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $usertype = $row['u_type'];
    if ($usertype !== '2' && $usertype !== '0') {
        http_response_code(404);
        echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL '.$_SERVER["SCRIPT_NAME"].' was not found on this server.</p><hr><address>Apache/2.4.18 (Ubuntu) Server at aws.azureagst.pw Port 80</address></body></html>';
        exit();
    } elseif ($usertype === '2' || $usertype === '0') {
    
        //allow volunteers in

    } else {
        http_response_code(404);
        echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL '.$_SERVER["SCRIPT_NAME"].' was not found on this server.</p><hr><address>Apache/2.4.18 (Ubuntu) Server at aws.azureagst.pw Port 80</address></body></html>';
        exit();
    }
?>

<div class="container">
    <?php 
        if ($_SERVER["QUERY_STRING"] === "error=no_user") {
            echo '<div class="alert alert-danger" role="alert">No User Found! Did you type the name right?</div><br>';
        } elseif ($_SERVER["QUERY_STRING"] === "error=empty") {
            echo '<div class="alert alert-danger" role="alert">You left an empty field. Try again, and make sure everything is filled out.</div><br>';
        } elseif ($_SERVER["QUERY_STRING"] === "error=false_house") {
            echo '<div class="alert alert-danger" role="alert">That is not their house...</div><br>';
        } elseif ($_SERVER["QUERY_STRING"] === "error=already_here") {
            echo '<div class="alert alert-danger" role="alert">They are already here...</div><br>';
        } elseif ($_GET['success'] !== null) {
            echo "<div class='alert alert-success' role='alert'>".$_GET['success']." is checked in!</div><br>";
        } elseif ($_GET['signup'] !== null) {
            echo "<div class='alert alert-success' role='alert'>".$_GET['signup']." is checked in! Tell them to create an account before the next event, otherwise they wont be able to check into thir next event!</div><br>";
        }
    ?>
    <h3>Volunteer Check-In Page</h3>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Need help?
    </button>
    <hr>
    <br>
    <form action="./backend/checkin.inc.php" method="POST">
        <div class="row">
            <div class="col">
                <label for="inputFirst">First Name:</label>
                <input type="text" name="u_firstname" id="inputFirst" class="form-control" placeholder="First Name" required autofocus>
            </div>
            <div class="col">
                <label for="inputLast">Last Name:</label>
                <input type="text" name="u_lastname" id="inputLast" class="form-control" placeholder="Last Name" required>
            </div>
        </div>
        <label for="sel1">House:</label>
        <select class="form-control" id="sel1" name="u_house">
            <option value="Aquinas">Aquinas</option>
            <option value="Augustine">Augustine</option>
            <option value="Bonaventure">Bonaventure</option>
            <option value="Hildegard">Hildegard</option>
        </select>
        <label for="sel2">Event:</label>
        <select class="form-control" id="sel2" name="select_event">
            <?php
                //i have to do this every time?????
                $currentDay = date("Y-m-d");
                $currentTime = date("h:i:s");
                $CurrentTimestamp = $currentDay.' '.$currentTime; //yay sql formatting!
                $sql = "SELECT event_name from eventlist where (start_time < '$CurrentTimestamp') and ('$CurrentTimestamp' < end_time)";
                $query = mysqli_query($conn, $sql);
                $result = mysqli_num_rows($query);
                if ($result > '0') {
                    while($row = mysqli_fetch_assoc($query)) {
                        echo "<option value='$row[event_name]'>$row[event_name]</option>";
                    }
                } else {
                    echo "<option value='na'>N/A</option>";
                }
            ?>
        </select>
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Check in</button>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">How To Check Students In:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Hey there! Thanks for volunteering to support our local panthers! Here's how to check someone in:</p>
                <p>When a student walks up to you to check into an event, start off by asking them for their Student ID, or some form of verification. This is to make sure a student can't check in under a false name. Type their first and last name, into the respective boxes.</p>
                <p>Then, ask the student for their house, and select it from the box.</p>
                <p>Lastly, make sure that the event you're checking people in for is selected in the last box. From there click submit and the student should be checked in!</p>
                <div class='alert alert-primary' role='alert'>
                    If an error is encountered, just do what pops up onto the screen. However, if the error "what." pops up onto the screen, please contact Mrs. Young or Andrew Augustine, to fix the problem. Until it's fixed, do the same procedure, just on pen and paper.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Got it!</button>
            </div>
        </div>
    </div>
</div>

<script>
//i hate javascript
$(document).ready(function(){
    $("#exampleModal").modal("show");
});

//with a passion
</script>
<?php
    include_once 'footer.php';
?>