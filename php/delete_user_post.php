<?php
	include('connect_db.php');

	if(isset($_COOKIE['signed_username']))
	{
		$signed_username = $_COOKIE['signed_username'];
		$this_post_id = $_POST['this_post_id'];
		$post_id = $signed_username . "_post_" . $this_post_id;

	//checking if that post also contain any image or video
		$check_post_media_query = "SELECT * FROM " . $signed_username . "_post WHERE id = '$this_post_id'";
		$check_post_media_query_run = mysqli_query($connect_link, $check_post_media_query);
		$check_post_media_assoc = mysqli_fetch_assoc($check_post_media_query_run);

		$check_post_media_photo = $check_post_media_assoc['photo'];
		$check_post_media_video = $check_post_media_assoc['video'];

	//deleting the photo of that post
		if($check_post_media_photo != "")
		{
		//deleting the photo file
			$image_location = "../img/" . $signed_username . "_photo/" . $check_post_media_photo;
			unlink($image_location);

		//removing that photo row from the media table
			$remove_photo_media_query = "DELETE FROM " . $signed_username . "_media WHERE photo = '$check_post_media_photo'";
			$remove_photo_media_query_run = mysqli_query($connect_link, $remove_photo_media_query);
		}

	//deleting the video of that post
		if($check_post_media_video != "")
		{
		//deleting the video file
			$video_location = "../vid/" . $signed_username . "_video/" . $check_post_media_video;
			unlink($video_location);

		//removing that video row from the media table
			$remove_video_media_query = "DELETE FROM " . $signed_username . "_media WHERE video = '$check_post_media_video'";
			$remove_video_media_query_run = mysqli_query($connect_link, $remove_video_media_query);
		}		

	//delete rows associated with that post in post, likes, comments and notification table
		$delete_user_post_query = "DELETE FROM " . $signed_username . "_post WHERE id ='" . $this_post_id . "'";
		$delete_post_likes_rows_query = "DELETE FROM likes WHERE post_user = '$signed_username' AND post_id = '$post_id'";
		$delete_post_comments_rows_query = "DELETE FROM comments WHERE post_user = '$signed_username' AND post_id = '$post_id'";
		$delete_post_notification_rows_query = "DELETE FROM user_notifications WHERE notifi_user = '$signed_username' AND post_id ='$this_post_id'";

	//deleting that post id from fvrt_post_id column in the user_info table
		$delete_fvrt_post_id_query = "DELETE FROM " . $signed_username . "_info WHERE fvrt_post_id = " . $this_post_id ;
		if(mysqli_query($connect_link, $delete_user_post_query) && mysqli_query($connect_link, $delete_post_likes_rows_query) && mysqli_query($connect_link, $delete_post_comments_rows_query) && mysqli_query($connect_link, $delete_post_notification_rows_query) && mysqli_query($connect_link, $delete_fvrt_post_id_query))
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