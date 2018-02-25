<?php
	include('connect_db.php');
	$change_setting_query = htmlentities($_POST['query_to_send']);

	if($change_setting_query_run = mysqli_query($connect_link, $change_setting_query))
	{
		echo 1;
	}
	else
	{
		echo 0;
	}

?>