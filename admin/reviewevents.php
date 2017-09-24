<?php
include_once '../backend/config.php';
include_once '../header.php';
include_once 'adminheader.php';

//-----[See if any event hasnt been ported]-----
$sql = "SELECT * FROM eventlist WHERE ('$CurrentTimestamp' > end_time)";
$result = mysqli_query($conn, $sql);
$row = mysqli_num_rows($result);

if ($_SERVER["QUERY_STRING"] === "error=empty") {
    echo '<div class="alert alert-danger" role="alert">Woah something was empty!</div><br>';
} elseif ($_GET['success'] !== null) {
    echo '<div class="alert alert-success" role="alert">Event '.$_GET['success'].' was merged!</div><br>';
}
?>
<h4>Review Events</h4>
<hr>
<?php
if ($row > 0) {
    echo "<p>You have ".$row." event(s) that haven't been reviewed yet.</p>";
    $rowData = mysqli_fetch_assoc($result); 

    $eventname = $rowData['event_name'];
    $end_time = $rowData['end_time'];
    $Aquinas = $rowData['Aquinas'];
    $Augustine = $rowData['Augustine'];
    $Bonaventure = $rowData['Bonaventure'];
    $Hildegard = $rowData['Hildegard'];

    echo '<hr>';
    echo '<div>';
    echo '    <form action="../backend/merge.inc.php" method="POST">';
    echo '        <div class="row">';
    echo '            <div class="col-md-6">';
    echo '               <h5>'.$eventname.'</h5>';
    echo '               <br>';
    echo '               <p>Aquinas Earned: <b>'.$Aquinas.'</b> points</p>';
    echo '                <p>Augustine Earned: <b>'.$Augustine.'</b> points</p>';
    echo '                <p>Bonaventure Earned: <b>'.$Bonaventure.'</b> points</p>';
    echo '                <p>Hildegard Earned: <b>'.$Hildegard.'</b> points</p>';
    echo '            </div>';
    echo '            <div class="col-md-3">';
    echo '                <p>Do these look correct?</p>';
    echo '                <div class="checkbox">';
    echo '                    <label><input type="checkbox" name="correct" value="yes"> Yes</label>';
    echo '                </div>';
    echo '                <hr>';
    echo '                <p>Do you approve the merging of this data into the main table?</p>';
    echo '                <div class="checkbox">';
    echo '                   <label><input type="checkbox" name="approve" value="yes"> Yes</label>';
    echo '               </div>';
    echo '            </div>';
    echo '           <div class="col-md-3">';
    echo '              <p>Any bonus points?</p>';
    echo '              <input type="text" name="Aq_Bonus" id="inputFirst" class="form-control" placeholder="Aquinas Bonus Points">';
    echo '               <input type="text" name="Ag_Bonus" id="inputFirst" class="form-control" placeholder="Augustine Bonus Points">';
    echo '               <input type="text" name="Bn_Bonus" id="inputFirst" class="form-control" placeholder="Bonaventure Bonus Points">';
    echo '               <input type="text" name="Hi_Bonus" id="inputFirst" class="form-control" placeholder="Hildegard Bonus Points">';
    echo '           </div>';
    echo '       </div>';
    echo '       <button name="submit" class="btn btn-outline-warning my-2 my-sm-0 float-right">Merge</button>';
    echo '   </form>';
    echo '</div>';
    echo '<hr>';

} else {
    echo "<p>You have 0 event(s) that haven't been reviewed yet! Yay!</p>";
    echo "<hr>";
}
?>
<?php
include_once 'adminfooter.php';
?>