<script>
//yay external!

//get values
var Aquinas = <?php echo json_encode($totalRow[0]); ?>;
var Augustine = <?php echo json_encode($totalRow[1]); ?>;
var Bonaventure = <?php echo json_encode($totalRow[2]); ?>;
var Hildegard = <?php echo json_encode($totalRow[3]); ?>;

//MATH TIME!!1!
var Total = +Aquinas + +Augustine + +Bonaventure + +Hildegard;
var AqPct = +Aquinas / +Total * 100;
var AuPct = +Augustine / +Total * 100;
var BnPct = +Bonaventure / +Total * 100;
var HlPct = +Hildegard / +Total * 100;
var AqPct2 = +AqPct * 2;
var AuPct2 = +AuPct * 2;
var BnPct2 = +BnPct * 2;
var HlPct2 = +HlPct * 2;
</script>

<?php
//fuck it, ima convert all the data conversion methods to php, to get rid of that document.write error

$Aquinas = $totalRow[0];
$Augustine = $totalRow[1];
$Bonaventure = $totalRow[2];
$Hildegard = $totalRow[3];

//MATH TIME!!1!
$Total = $Aquinas + $Augustine + $Bonaventure + $Hildegard;
$AqPct = $Aquinas / $Total * 100;
$AuPct = $Augustine / $Total * 100;
$BnPct = $Bonaventure / $Total * 100;
$HlPct = $Hildegard / $Total * 100;
$AqPct2 = $AqPct * 2;
$AuPct2 = $AuPct * 2;
$BnPct2 = $BnPct * 2;
$HlPct2 = $HlPct * 2;

?>