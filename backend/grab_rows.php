<?php
//first most recent, store array in "$row"
$sql = "SELECT * FROM testpts ORDER BY Event_Date DESC LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_row();

//second most recent, store array in "$row2"
$temp1 = $row[0] - 1;
$sql2 = "SELECT * FROM testpts WHERE (ID=".$temp1.");";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_row();

//third most recent, store array in "$row3"
$temp2 = $row[0] - 2;
$sql3 = "SELECT * FROM testpts WHERE (ID=".$temp2.");";
$result3 = $conn->query($sql3);
$row3 = $result3->fetch_row();

//find sums of point columns, store array in "$totalRow"
$sql4 = "SELECT sum(Aquinas), sum(Augustine), sum(Bonaventure), sum(Hildegard) FROM testpts; ";
$result4 = $conn->query($sql4);
$totalRow = $result4->fetch_row();

//holy shit this is janky
?>