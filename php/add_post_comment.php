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
			// $add_notification_query = "INSERT INTO user_notifications VALUES('', '$username', 'comment', '$this_post_id', '$signed_username', 'has commented on your post.', now())";
			// $add_notification_query_run = mysqli_query($connect_link, $add_notification_query);	

		//getting old comments of that post
			$get_old_comments_query = "SELECT notifi_by FROM user_notifications WHERE post_id = '$this_post_id' AND notifi_user = '$username' AND notifi_type = 'comment'";
			$get_old_comments_query_run = mysqli_query($connect_link, $get_old_comments_query);
			$get_old_comments_assoc = mysqli_fetch_assoc($get_old_comments_query_run);
			$get_old_comments = $get_old_comments_assoc['notifi_by'];

		//checking if that name is already in notifi_by or not 
			if(strpos($get_old_comments, $signed_username) === false)
			{
				$new_comments = $signed_username . ", " . $get_old_comments;

			//updating the likes of that post in the notifaiction table of that post
				$add_notification_query = "UPDATE user_notifications SET notifi_by = '$new_comments' WHERE post_id = '$this_post_id' AND notifi_user = '$username' AND notifi_type = 'comment'";
				$add_notification_query_run = mysqli_query($connect_link, $add_notification_query);

			//updating view of that post in the notifaiction table of that post
				$add_notification_query = "UPDATE user_notifications SET view = '1' WHERE post_id = '$this_post_id' AND notifi_user = '$username' AND notifi_type = 'comment'";
				$add_notification_query_run = mysqli_query($connect_link, $add_notification_query);
			}
			else
			{
				$new_comments = $get_old_comments;

			//updating the likes of that post in the notifaiction table of that post
				$add_notification_query = "UPDATE user_notifications SET notifi_by = '$new_comments' WHERE post_id = '$this_post_id' AND notifi_user = '$username' AND notifi_type = 'comment'";
				$add_notification_query_run = mysqli_query($connect_link, $add_notification_query);

			//updating view of that post in the notifaiction table of that post
				$add_notification_query = "UPDATE user_notifications SET view = '1' WHERE post_id = '$this_post_id' AND notifi_user = '$username' AND notifi_type = 'comment'";
				$add_notification_query_run = mysqli_query($connect_link, $add_notification_query);
			}
		}
		
		echo 1;
	}
	else
	{
		echo 0;
	}

?>