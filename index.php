<?php
    //fuckin php, man. gotta hate it.
    include_once './backend/config.php';
    include_once './backend/grab_rows.php';
    include_once 'header.php';
    include_once './backend/pointmath.php';

    if (isset($_SESSION[u_uid])) {
        $personalize = 1;
    }
?>
<div class="container">
    <div class="alert alert-primary" role="alert">Project Counters is looking for new members to help out! <a href="./now_hiring.php">Come check the open positions!</a></div>
    <?php 
        if ($_SERVER["QUERY_STRING"] === "signup=success") {
            echo '<div class="alert alert-success" role="alert">Your account was created! Now log in!</div>';
        } elseif ($_SERVER["QUERY_STRING"] === "error=fuck_off") {
            echo '<div class="alert alert-danger" role="alert">dude, stop trying to hack the site.</div>';
        } elseif ($_SERVER["QUERY_STRING"] === "error=what") {
            echo '<div class="alert alert-danger" role="alert">what.</div>';
        }
    ?>
    <div class="jumbotron">
        <?php
            if ($personalize === 1) {
                echo "<H1>Welcome back ".$_SESSION[u_first]."!</H1>";
                echo "<h5>You've gotten ".$_SESSION[u_points]." points for your house.</h5>";
                echo "<h5>Here's how House ".$_SESSION[u_house]." is doing:</h5>";
                echo "<hr>";
                echo "<h6>Most recent event: ".json_encode($row[2])."</h6>";
                echo "<hr>";
            } else {
                echo '<H1>Current Points:</H1>';
                echo "<h5>as of ".$row[1]."</h5>";
                echo '<hr>';
                echo "<h5>Most recent event: ".json_encode($row[2])."</h5>";
                echo '<hr>';
            }
        ?>
        <!-- Chart showing first half of a 200% scale. This is safe assuming no team will get more than 50% of the total points available. -->
        <p><b>Aquinas Total:</b> <?php echo $totalRow[0]; ?></p>
        <div class="progress">
            <?php echo "<div class='progress-bar bg-success' role='progressbar' style='width: ".$AqPct2."%' aria-valuenow=".$AqPct." aria-valuemin='0' aria-valuemax='50'></div>"; ?>
        </div>
        <p><b>Augustine Total:</b> <?php echo $totalRow[1]; ?></p>
        <div class="progress">
            <?php echo "<div class='progress-bar bg-warning' role='progressbar' style='width: ".$AuPct2."%' aria-valuenow=".$AuPct." aria-valuemin='0' aria-valuemax='50'></div>"; ?>
        </div>
        <p><b>Bonaventure Total:</b> <?php echo $totalRow[2]; ?></p>
        <div class="progress">
            <?php echo "<div class='progress-bar bg-info' role='progressbar' style='width: ".$BnPct2."%' aria-valuenow=".$BnPct." aria-valuemin='0' aria-valuemax='50'></div>"; ?>
        </div>
        <p><b>Hildegard Total:</b> <?php echo $totalRow[3]; ?></p>
        <div class="progress">
            <?php echo "<div class='progress-bar bg-danger' role='progressbar' style='width: ".$HlPct2."%' aria-valuenow=".$HlPct." aria-valuemin='0' aria-valuemax='50'></div>"; ?>
        </div>
        <hr>
    </div>

    <!--Recent Events-->

    <h3>Recent Events:</h3>
    <hr>
    <div id="Event 1">
        <h4><?php echo $row[2];?>:</h4>
        <p>Aquinas: <?php echo $row[3];?></p>
        <p>Augustine: <?php echo $row[4];?></p>
        <p>Bonaventure: <?php echo $row[5];?></p>
        <p>Hildegard: <?php echo $row[6];?></p>
    </div>
    <hr>
    <div id="Event 2">
        <h4><?php echo $row2[2];?>:</h4>
        <p>Aquinas: <?php echo $row2[3];?></p>
        <p>Augustine: <?php echo $row2[4];?></p>
        <p>Bonaventure: <?php echo $row2[5];?></p>
        <p>Hildegard: <?php echo $row2[6];?></p>
    </div>
    <hr>
    <div id="Event 3">
        <h4><?php echo $row3[2];?>:</h4>
        <p>Aquinas: <?php echo $row3[3];?></p>
        <p>Augustine: <?php echo $row3[4];?></p>
        <p>Bonaventure: <?php echo $row3[5];?></p>
        <p>Hildegard: <?php echo $row3[6];?></p>
    </div>
    <hr>
    <!--Footer-->
    <p>&copy; 2017 Andrew Augustine</p>
</div>

<?php
include_once 'footer.php';
?>