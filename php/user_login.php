<?php
	//logging the user in the database/site

	include('connect_db.php');
	
	$email_login = strtolower(htmlentities(mysqli_real_escape_string($connect_link,$_POST['email_login'])));
	$pass_login = htmlentities(mysqli_real_escape_string($connect_link,md5($_POST['pass_login'])));

	$user_login_query = "SELECT * FROM users WHERE email = '$email_login' AND password = '$pass_login'";
	$user_login_query_run = mysqli_query($connect_link, $user_login_query);
	
	$user_login_num_rows = mysqli_num_rows($user_login_query_run);

	if($user_login_num_rows ==1)
	{
		$user_info_result= mysqli_fetch_row($user_login_query_run);
		$user_info_id = $user_info_result[0];
		$user_info_username = $user_info_result[2];

		setcookie('signed_user_id', $user_info_id, 2147483647, "/");
		setcookie('signed_username', $user_info_username, 2147483647, "/");
		
		echo $user_info_username;
	}
	else
	{
		echo 0;
	}
?>