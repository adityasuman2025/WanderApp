<?php
	include('connect_db.php');
	$query_to_send = $_POST['query_to_send'];

	$change_comp_query = $query_to_send;
	if($change_comp_query_run = mysqli_query($connect_link, $change_comp_query))
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>