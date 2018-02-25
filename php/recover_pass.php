<?php
	//for recovering the password of the user
	include ('connect_db.php');

	$new_password = htmlentities(mysqli_real_escape_string($connect_link, md5($_POST['new_password'])));
	$recovery_email = $_POST['recovery_email'];

	$pass_recov_query = "UPDATE users set password = '$new_password' WHERE email = '$recovery_email'";

	if($pass_recov_query_run = mysqli_query($connect_link, $pass_recov_query))
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>