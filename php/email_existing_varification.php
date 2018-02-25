<?php
	//varifying during registering if that email already exists

	include('connect_db.php');

	//if directyly visiting the page
		if(isset($_POST['email']))
		{

		}
		else
		{
			die('not allowed');
		}

	$email = strtolower(htmlentities(mysqli_real_escape_string($connect_link,$_POST['email'])));

	$email_varification_query = "SELECT id FROM users WHERE email = '$email'";

	$email_varification_query_run = mysqli_query( $connect_link ,$email_varification_query);
	$email_varification_num_rows = mysqli_num_rows($email_varification_query_run);
	
	if($email_varification_num_rows >= 1)
	{
		echo 0;
	}
	else
	{
		echo 1;	
	}

?>