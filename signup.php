<?php
    include_once 'header.php';

    if ($_SESSION['u_id'] !== null) {
        echo "boy, get outta here with that XSS/SQL injection attempt. use <a href='http://demo.testfire.net/'>this site</a> for that kinda shit.";
        header('Location: ./index.php');
        exit;
    }
?>

<div class="jumbotron">
    <?php

    if ($_SERVER["QUERY_STRING"] === "error=empty_field") {
        echo "<div class='alert alert-danger' role='alert'>There was an empty field below. Make sure to fill out all the fields unless they're marked as optional.</div><br>";
    } elseif ($_SERVER["QUERY_STRING"] === "error=invalid_name") {
        echo "<div class='alert alert-danger' role='alert'>That name isn't valid. Try again, making sure your name only includes the characters a-z and A-Z. In the case a special exception needs to be made, please contact the school.</div><br>";
    } elseif ($_SERVER["QUERY_STRING"] === "error=no_admin") {
        echo "<div class='alert alert-danger' role='alert'>Really? Admin's obviously taken. Stop trying to show off how cool you are to your friends. Just get off your ass and make your own PHP server.</div><br>";
    } elseif ($_SERVER["QUERY_STRING"] === "error=invalid_email") {
        echo "<div class='alert alert-danger' role='alert'>That email isnt't valid. Try again, making sure your email if formatted properly.</div><br>";
    } elseif ($_SERVER["QUERY_STRING"] === "error=user_taken") {
        echo "<div class='alert alert-danger' role='alert'>Sorry, that username was taken. Try again with a different username.</div><br>";;
    } 
    ?>
    <form class="form-signin" action="./backend/signup.inc.php" method="POST">
        <h2 class="form-signin-heading">Please sign up:</h2>
        <hr>
        <p>First Name:</p>
            <input type="text" name="first" class="form-control" placeholder="Required">
        <br>
        <p>Last Name:</p>
            <input type="text" name="last" class="form-control" placeholder="Required">
        <br>
        <p>Email:</p>
            <input type="email" name="email" class="form-control" placeholder="Required">
        <br>
        <p>Username:</p>
            <input type="text" name="uid" class="form-control" placeholder="Required">
        <br>
        <p>Password:</p>
            <input type="password" name="pwd" class="form-control" placeholder="Required">
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Submit</button>
    </form>
</div> <!-- /container -->

<?php
    include_once 'footer.php';
?>