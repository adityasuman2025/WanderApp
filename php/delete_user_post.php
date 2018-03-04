<?php
	include('connect_db.php');

	if(isset($_COOKIE['signed_username']))
	{
		$signed_username = $_COOKIE['signed_username'];
		$this_post_id = $_POST['this_post_id'];

		$delete_user_post_query = "DELETE FROM " . $signed_username . "_post WHERE id ='" . $this_post_id . "'";

		if($delete_user_post_query_run = mysqli_query($connect_link, $delete_user_post_query))
		{
			echo 1;			
		}
		else
		{
			echo 0;
		}
	}
	else
	{
		echo 0;
	}
?>