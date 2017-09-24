<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Points</title>
        <!-- Stylesheets -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link rel="stylesheet" href="http://aws.azureagst.pw/points/include/css/global.css">
        <!-- Meta Tags -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:title" content="Points Test Server">
        <meta property="og:description" content="AWS server dedicated to the development of Project Counters.">
        <meta property="og:image" content="http://aws.azureagst.pw/points/icon.png">
        <meta property="og:url" content="http://aws.azureagst.pw/points/index.php">
        <meta name="twitter:card" content="summary">

        <!-- moved jquery to top so we can reference it in site code -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
      
        ga('create', 'UA-106606305-1', 'auto');
        ga('send', 'pageview');
      
        </script>

    </head>
    <body>
        <!--Navbar-->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="https://aws.azureagst.pw/points/index.php">Points!</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="https://aws.azureagst.pw/points/index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Houses
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="https://aws.azureagst.pw/points/house/aquinas.php">Aquinas</a>
                            <a class="dropdown-item" href="https://aws.azureagst.pw/points/house/augustine.php">Augustine</a>
                            <a class="dropdown-item" href="https://aws.azureagst.pw/points/house/bonaventure.php">Bonaventure</a>
                            <a class="dropdown-item" href="https://aws.azureagst.pw/points/house/hildegard.php">Hildegard</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://aws.azureagst.pw/points/leaderboard.php">Leaderboard</a>
                    </li>
                    <?php //are they admin?
                    if ($_SESSION[u_type] === '0') {
                        echo '<li class="nav-item">
                        <a class="nav-link" href="https://aws.azureagst.pw/points/admin/">Admin</a>
                        </li>';
                    }
                    ?>
                    <?php //are they volunteer or admin?
                    if ($_SESSION[u_type] === '2' || $_SESSION[u_type] === '0') {
                        echo '<li class="nav-item">
                        <a class="nav-link" href="https://aws.azureagst.pw/points/checkin.php">Check-In</a>
                        </li>';
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="https://trello.com/b/dveFesLt">To-Do</a>
                    </li>
                </ul>
                <?php
                if (isset($_SESSION[u_uid])) {
                    echo "<span class='navbar-text'>Welcome $_SESSION[u_first]!  </span>
                    <form action='https://aws.azureagst.pw/points/backend/logout.inc.php' method='POST'>
                    <button class='btn btn-outline-success my-2 my-sm-0' type='submit' name='submit'>Logout</button>
                    </form>";
                } else {
                    echo '<div class="headerlogin"><a class="btn btn-outline-success my-2 my-sm-0" href="https://aws.azureagst.pw/points/login.php">Login</a>
                    <a class="btn btn-outline-success my-2 my-sm-0" href="https://aws.azureagst.pw/points/signup.php">Sign-Up</a></div>';
                }
                ?>
            </div>
        </nav>