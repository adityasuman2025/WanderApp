<?php
	include('connect_db.php');

	$this_post_id = $_POST['this_post_id'];
	$username = $_POST['username'];
	$post_id = $_POST['username'] . "_post_" . $this_post_id;


	if(isset($_COOKIE['signed_username']))
	{
		$signed_username = $_COOKIE['signed_username'];

		$add_like_query = "INSERT INTO likes VALUES('', '" . $username . "', '" . $post_id . "', '" . $signed_username . "', now())";
		if($add_like_query_run = mysqli_query($connect_link, $add_like_query))
		{
			$like_count_query = "SELECT id FROM likes WHERE post_id = '$post_id'";
			$like_count_query_run = mysqli_query($connect_link, $like_count_query);
			echo $like_count = mysqli_num_rows($like_count_query_run);

		//adding this event in notification table
			if($signed_username != $username)
			{
				$add_notification_query = "INSERT INTO user_notifications VALUES('', '$username', 'like', '$this_post_id', '$signed_username', 'has liked your post.', now())";
				$add_notification_query_run = mysqli_query($connect_link, $add_notification_query);
		
			}
		}
	}
	else
	{
		$signed_username = null;
	}
?>