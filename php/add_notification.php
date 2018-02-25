<?php
	include('connect_db.php');

	$add_notification_query = $_POST['add_notification_query'];

	if($add_notification_query_run = mysqli_query($connect_link, $add_notification_query))
	{
		echo 1;
	}
	else
	{
		echo 0;
	}

?>