<?php
	include('connect_db.php');
	$query_to_send = $_POST['query_to_send'];
	$get_user_post_count_query = $query_to_send;

	if($get_user_post_count_query_run = mysqli_query($connect_link, $get_user_post_count_query))
	{
		echo $get_user_post_count = mysqli_num_rows($get_user_post_count_query_run);
	}
?>