<?php 
include_once "./backend/config.php";
include_once "header.php";
?>
<div class="container">
    <div class="jumbotron">
        <h2>User Leaderboards:</h2>
        <h4>Beat your friends!</h4>
    </div>
    <div class="row">
        <div class="col-8">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Place</th>
                    <th>Name</th>
                    <th>House</th>
                    <th>Points</th>
                </tr>
                </thead>
                <tbody>
                <?php
                //for place:
                $incplace = 1;

                //actual sql
                $sql2 = "SELECT * FROM users ORDER BY u_points DESC LIMIT 0, 20;";
                $query2 = mysqli_query($conn, $sql2);
                $result2 = mysqli_num_rows($query2);
                if ($result2 > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($query2)) {
                        echo '<tr><th>'.$incplace.'</th><td>'.$row["u_firstname"].' '.$row["u_lastname"].'</td><td>'.$row["u_house"].'</td><td>'.$row["u_points"].'</td></tr>';           
                        $incplace = $incplace + 1;
                    }
                } else {
                    echo "<tr><th>N/A</th><td>N/A</td><td>N/A</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-4 text-right">
            <h5>placeholder text</h5>
            <p>search will eventually go here</p>
        </div>
    </div>
</div>
<?php
include_once "footer.php";
?>