<?php
session_start();

if (isset($_POST['submit'])) {
    include_once 'config.php';

    $EventName = mysqli_real_escape_string($conn, $_POST['event_name']);
    $StartTime = mysqli_real_escape_string($conn, $_POST['start_time']);
    $EndTime = mysqli_real_escape_string($conn, $_POST['end_time']);
    $PointVal = mysqli_real_escape_string($conn, $_POST['point_value']);
    echo "$EventName, $StartTime, $EndTime, $PointVal.";

    if ($EventName === null || $StartTime === null || $EndTime === null || $PointVal === null) {
        //header("Location: ../admin/createevent.php?error=empty");
        exit();
    }

    if (!preg_match("/^(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})$/",$StartTime) || !preg_match("/^(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})$/",$EndTime)) {
        header("Location: ../admin/createevent.php?error=invalid_date");
        exit();
    }

    //check to see if it exists
    $sql = "SELECT * FROM eventlist WHERE (event_name='$EventName');";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        header("Location: ../admin/createevent.php?error=already_exists");
        exit();
    }

    $sql = "INSERT INTO eventlist (event_name, start_time, end_time, point_worth, Aquinas, Augustine, Bonaventure, Hildegard) values ('$EventName', '$StartTime', '$EndTime', '$PointVal', '0', '0', '0', '0');";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    //eZ pZ
    echo 'done!';

    header("Location: ../admin/createevent.php?success=$EventName");
    exit();
} else {
    header("Location: ../index.php?error=fuck_off");
    exit();
}