<?php
    include_once 'header.php';

  if ($_SESSION['u_id'] !== null) {
    echo "boy, get outta here with that XSS/SQL injection attempt. use <a href='http://demo.testfire.net/'>this site</a> for that kinda shit.";
    header('Location: ./index.php');
    exit;
  }
?>
<style>
body {
  padding-bottom: 40px;
  background-color: #eee;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
<div class="container">

  <?php

  if ($_SERVER["QUERY_STRING"] === "login=empty") {
      echo '<div class="alert alert-danger" role="alert">Something was empty. Try again.</div><br>';
  } elseif ($_SERVER["QUERY_STRING"] === "login=error") {
      echo '<div class="alert alert-danger" role="alert">The username or password was not correct. Try again.</div><br>';
  }
  ?>

    <form class="form-signin" action="./backend/login.inc.php" method="POST">
    <h2 class="form-signin-heading">Please sign in</h2>
    <label for="inputEmail" class="sr-only">Username</label>
    <input type="text" name="uid" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="pwd" id="inputPassword" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
    </form>

</div> <!-- /container -->
<?php
    include_once 'footer.php';
?>