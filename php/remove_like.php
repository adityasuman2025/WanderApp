<?php
	include('connect_db.php');

	$this_post_id = $_POST['this_post_id'];
	$username = $_POST['username'];
	$post_id = $_POST['username'] . "_post_" . $this_post_id;


	if(isset($_COOKIE['signed_username']))
	{
		$signed_username = $_COOKIE['signed_username'];

		$add_like_query = "DELETE FROM likes WHERE post_id = '$post_id' AND user_name = '$signed_username'";
		if($add_like_query_run = mysqli_query($connect_link, $add_like_query))
		{
			$like_count_query = "SELECT id FROM likes WHERE post_id = '$post_id'";
			$like_count_query_run = mysqli_query($connect_link, $like_count_query);
			echo $like_count = mysqli_num_rows($like_count_query_run);

		//removing this event in notification table
			if($signed_username != $username)
			{
				// $add_notification_query = "DELETE FROM user_notifications WHERE notifi_user='$username' AND notifi_type='like' AND post_id='$this_post_id' AND notifi_by='$signed_username'";
				// $add_notification_query_run = mysqli_query($connect_link, $add_notification_query);

			//getting old likes of that post
				$get_old_likes_query = "SELECT notifi_by FROM user_notifications WHERE post_id = '$this_post_id' AND notifi_user = '$username' AND notifi_type = 'like'";
				$get_old_likes_query_run = mysqli_query($connect_link, $get_old_likes_query);
				$get_old_likes_assoc = mysqli_fetch_assoc($get_old_likes_query_run);
				$get_old_likes = $get_old_likes_assoc['notifi_by'];
			
				$to_remove = $signed_username . ", ";
				$new_likes = str_replace($to_remove, "", $get_old_likes);

			//updating the likes of that post in the notification table of that post
				$remove_notification_query = "UPDATE user_notifications SET notifi_by = '$new_likes' WHERE post_id = '$this_post_id' AND notifi_user = '$username' AND notifi_type = 'like'";
				$remove_notification_query_run = mysqli_query($connect_link, $remove_notification_query);

			//updating view of that post in the notification table of that post
				$add_notification_query = "UPDATE user_notifications SET view = '0' WHERE post_id = '$this_post_id' AND notifi_user = '$username' AND notifi_type = 'like'";
				$add_notification_query_run = mysqli_query($connect_link, $add_notification_query);
			}
		}
	}
	else
	{
		$signed_username = null;
	}
?>