<?php
//server side auth
$sql = "SELECT * FROM users WHERE u_uid='$_SESSION[u_uid]';";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$usertype = $row['u_type'];
if ($usertype !== '0') {
    http_response_code(404);
    echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL '.$_SERVER["SCRIPT_NAME"].' was not found on this server.</p><hr><address>Apache/2.4.18 (Ubuntu) Server at aws.azureagst.pw Port 80</address></body></html>';
    exit();
} elseif ($usertype === '0') {

    //eh nothing really needs to go here

} else {
    header("Location: ../index.php?error=what");
    exit();
}

$currentpage = $_SERVER['SCRIPT_NAME'];
$nav1 = 'class="nav-link" href="./index.php"';
$nav2 = 'class="nav-link" href="./masterrecord.php"';
$nav3 = 'class="nav-link" href="./reviewevents.php"';
$nav4 = 'class="nav-link" href="./createevent.php"';
if ($currentpage === "/points/admin/index.php") {
    $nav1 = 'class="nav-link active" href="./index.php"';
} elseif ($currentpage === "/points/admin/masterrecord.php") {
    $nav2 = 'class="nav-link active" href="./masterrecord.php"';   
} elseif ($currentpage === "/points/admin/reviewevents.php") {
    $nav3 = 'class="nav-link active" href="./reviewevents.php"';   
} elseif ($currentpage === "/points/admin/createevent.php") {
    $nav4 = 'class="nav-link active" href="./createevent.php"';   
}
$currentDay = date("Y-m-d");
$currentTime = date("h:i:s");
$CurrentTimestamp = $currentDay.' '.$currentTime; //yay sql formatting!
$sql = "SELECT * FROM eventlist WHERE ('$CurrentTimestamp' > end_time)";
$result = mysqli_query($conn, $sql);
$pendingNotif = mysqli_num_rows($result);

if ($pendingNotif > 0) {
    $notif = '<span class="badge badge-danger">'.$pendingNotif.'</span>';
} else {
    $notif = null;
}
// <span class="badge badge-secondary">4</span>

?>
<link href="dashboard.css" rel="stylesheet">
<div class="container-fluid">
    <div class="row">
        <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a <?php echo $nav1 ?> >Overview</a>
                </li>
                <li class="nav-item">
                    <a <?php echo $nav2 ?> >M.C.R.</a>
                </li>
                <li class="nav-item">
                    <a <?php echo $nav3 ?> >Review Events <?php echo $notif ?></a>
                </li>
                <li class="nav-item">
                    <a <?php echo $nav4 ?> >Create Event</a>
                </li>
            </ul>
        </nav>
        <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">

