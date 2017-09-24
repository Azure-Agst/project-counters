<?php

if (isset($_POST['submit'])) {

    include_once 'config.php';

    $first = mysqli_real_escape_string($conn, $_POST['first']);
    $last = mysqli_real_escape_string($conn, $_POST['last']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

    //Error Handling
    //Fuck mmtuts, nested if statements are gross. Let's use ElseIf's if we can.

    if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd)) {
        header("Location: ../signup.php?error=empty_field");
        exit();
    } elseif (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
        header("Location: ../signup.php?error=invalid_name");
        exit();
    } elseif ($uid == "Admin") {
        header("Location: ../signup.php?error=no_admin");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalid_email");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE u_uid='$uid';";
        $return = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($return);

        if ($resultCheck > 0) {
            header("Location: ../signup.php?error=user_taken");
            exit();
        } else {
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
            $insertcmd = "INSERT INTO users (u_firstname, u_lastname, u_email, u_uid, u_pwd, u_type, u_house, u_points) VALUES ('$first','$last','$email','$uid','$hashedPwd', 1, 'Unassigned', 0);";
            mysqli_query($conn, $insertcmd);
            header("Location: ../index.php?signup=success");
            exit();
        }
    }

} else {
    header("Location: ../index.php?error=fuck_off");
    exit();
}

//VOL - JPVolunteer1#
//ADM - JPIIchs#2017