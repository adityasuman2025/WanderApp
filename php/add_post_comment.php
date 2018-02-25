<?php
	include('connect_db.php');

	if(isset($_COOKIE['signed_username']))
	{
		$signed_username = $_COOKIE['signed_username'];
	}
	else
	{
		$signed_username = null;
	}

	$post_user = $_POST['post_user'];
	$username = $post_user;

	$post_id = $_POST['post_id'];
	$this_post_id = $_POST['this_post_id'];
	$signed_username = $_POST['signed_username'];
	$add_comment_text = htmlentities(mysqli_real_escape_string($connect_link, $_POST['add_comment_text']));

	$add_comment_query = "INSERT INTO comments VALUES('', '" . $post_user . "', '" . $post_id . "', '" . $signed_username . "', '" . $add_comment_text . "', now())";

	if($add_comment_query_run = mysqli_query($connect_link, $add_comment_query))
	{
	//adding this event in notification table
		if($signed_username != $username)
		{
			$add_notification_query = "INSERT INTO user_notifications VALUES('', '$username', 'comment', '$this_post_id', '$signed_username', 'has commented on your post.', now())";
			$add_notification_query_run = mysqli_query($connect_link, $add_notification_query);	
		}
		
		echo 1;
	}
	else
	{
		echo 0;
	}

?>