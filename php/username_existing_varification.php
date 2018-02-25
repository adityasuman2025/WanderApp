<?php
	//varifying during registering if that username already exists

	include('connect_db.php');

	//if directyly visiting the page
		if(isset($_POST['us_name_reg']))
		{

		}
		else
		{
			die('not allowed');
		}

	$us_name_reg = strtolower(htmlentities(mysqli_real_escape_string($connect_link, $_POST['us_name_reg'])));

	$username_varification_query = "SELECT id FROM users WHERE username = '$us_name_reg'";

	$username_varification_query_run = mysqli_query( $connect_link ,$username_varification_query);
	$username_varification_num_rows = mysqli_num_rows($username_varification_query_run);
	
	if($username_varification_num_rows >= 1)
	{
		echo 0;
	}
	else
	{
		echo 1;	
	}
?>