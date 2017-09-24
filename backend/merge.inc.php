<?php 
session_start();

////////////////////////////////////////
//                                    //
//           merge.inc.php            //
//        By: Andrew Augustine        //
//                                    //
////////////////////////////////////////

//prevent users from seeing the source code for exploiting, make sure the submit button was pressed
if (isset($_POST['submit'])) { 

    include_once 'config.php';

    //today is...
    $currentDay = date("Y-m-d");
    $currentTime = date("h:i:s");
    $CurrentTimestamp = $currentDay.' '.$currentTime; //yay sql formatting!  

    $sql = "SELECT * FROM eventlist WHERE ('$CurrentTimestamp' > end_time)";
    $result = mysqli_query($conn, $sql);
    $rowData = mysqli_fetch_assoc($result); 
    $eventname = $rowData['event_name'];
    $end_time = $rowData['end_time'];
    $RealAquinas = $rowData['Aquinas'];
    $RealAugustine = $rowData['Augustine'];
    $RealBonaventure = $rowData['Bonaventure'];
    $RealHildegard = $rowData['Hildegard'];  
    $correct = $_POST['correct'];
    $approve = $_POST['approve'];
    $AqBonus = mysqli_real_escape_string($conn, $_POST['Aq_Bonus']);
    $AgBonus = mysqli_real_escape_string($conn, $_POST['Ag_Bonus']);
    $BnBonus = mysqli_real_escape_string($conn, $_POST['Bn_Bonus']);
    $HiBonus = mysqli_real_escape_string($conn, $_POST['Hi_Bonus']);

    //---[That should be all the variables]-------------------------------------------------------------------------

    if ($correct !== 'yes' || $approve !== 'yes') {
        header("Location: ../admin/reviewevents.php?error=empty");
        exit();
    }

    $aqFinal = $RealAquinas + $AqBonus;
    $agFinal = $RealAugustine + $AgBonus;
    $bnFinal = $RealBonaventure + $BnBonus;
    $hiFinal = $RealHildegard + $HiBonus;

    $sql = "INSERT INTO testpts (Event_Date, Event_Name, Aquinas, Augustine, Bonaventure, Hildegard) VALUES ('$end_time','$eventname', '$aqFinal', '$agFinal', '$bnFinal', '$hiFinal');";
    //INSERT INTO testpts (Event_Date, Event_Name, Aquinas, Augustine, Bonaventure, Hildegard) VALUES ('$end_time','$eventname', $aqFinal, $agFinal, $bnFinal, $hiFinal);
    mysqli_query($conn, $sql);

    $sql2 = "DELETE FROM eventlist WHERE (event_name='$eventname');";
    mysqli_query($conn, $sql2);

    echo $eventname;
    echo $sql;
    echo $end_time;
    echo $CurrentTimestamp;

    header("Location: ../admin/reviewevents.php?success=$eventname");
    exit();

} else {
    header("Location: ../index.php?error=fuck_off");
    exit();
}
?>