<?php
//literally ripped from mmtuts and modified because it's 1:49 AM and i want to sleep

session_start();

if (isset($_POST['submit'])) {
	
	include 'config.php';

	$uid = mysqli_real_escape_string($conn, $_POST['uid']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

	//Error handlers
	//Check if inputs are empty
	if (empty($uid) || empty($pwd)) {
		header("Location: ../login.php?login=empty");
		exit();
	} else {
		//check to see if user exists
		$sql = "SELECT * FROM users WHERE u_uid='$uid' OR u_email='$uid'";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		if ($resultCheck < 1) {
			header("Location: ../login.php?login=error");
			exit();
		} else {
			if ($row = mysqli_fetch_assoc($result)) {
				//De-hashing the password
				$hashedPwdCheck = password_verify($pwd, $row['u_pwd']);
				if ($hashedPwdCheck == false) {
					header("Location: ../login.php?login=error");
					exit();
				} elseif ($hashedPwdCheck == true) {
					//Log in the user here
					$_SESSION['u_id'] = $row['u_id'];
					$_SESSION['u_first'] = $row['u_firstname'];
					$_SESSION['u_last'] = $row['u_lastname'];
					$_SESSION['u_email'] = $row['u_email'];
					$_SESSION['u_uid'] = $row['u_uid'];
					$_SESSION['u_type'] = $row['u_type'];
					$_SESSION['u_house'] = $row['u_house'];
					$_SESSION['u_points'] = $row['u_points'];
					header("Location: ../index.php?login=success");
					exit();
				}
			}
		}
	}
} else {
	header("Location: ../index.php?error=fuck_off");
	exit();
}