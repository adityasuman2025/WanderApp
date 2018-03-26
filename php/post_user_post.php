<?php

	include('connect_db.php');
	
	$signed_username = $_POST['signed_username'];

	$post_textarea = htmlentities(mysqli_real_escape_string($connect_link, $_POST['post_textarea']));
	$post_photo = $_POST['post_photo'];
	$post_video = $_POST['post_video'];
	$post_location = htmlentities(mysqli_real_escape_string($connect_link, $_POST['post_location']));

	if($post_photo != "0")
	{
	//for getting extension of uploaded file
		$test = explode(".", $post_photo);
		$image_extension = end($test);

	//setting the old name
		$post_photo = "../" . $post_photo;

	//setting new name and location of the uploaded pic
		$get_pic_no_query = "SELECT id FROM " . $signed_username . "_media";
		$get_pic_no_query_run = mysqli_query($connect_link, $get_pic_no_query);
		$get_pic_no_no = mysqli_num_rows($get_pic_no_query_run);

		$user_pic_name_no = $get_pic_no_no + 1;
		$image_name_new = "pic." . $user_pic_name_no . "." . $image_extension;
		$image_location = "../img/" . $signed_username . "_photo/" . $image_name_new;

		if(rename($post_photo, $image_location))
		{

		//updating photo in the media table of that user
			$update_photo_table_query = "INSERT INTO " . $signed_username . "_media VALUES('', '" . $image_name_new . "', now(), '" . $post_location ."', '', '', '')";
			$update_photo_table_query_run = mysqli_query($connect_link, $update_photo_table_query);

		//setting post_photo to only name of the pic so that it can be used as photo name while getting post
			$post_photo = $image_name_new;
		}
		else
		{
			echo "Something went wrong while transfering photo";
		}
	}
	else
	{
		$post_photo = null;
	}

	if($post_video != "0")
	{
	//for getting extension of uploaded file
		$test = explode(".", $post_video);
		$image_extension = end($test);

	//setting the old name
		$post_video = "../" . $post_video;

	//setting new name and location of the uploaded pic
		$get_pic_no_query = "SELECT id FROM " . $signed_username . "_media";
		$get_pic_no_query_run = mysqli_query($connect_link, $get_pic_no_query);
		$get_pic_no_no = mysqli_num_rows($get_pic_no_query_run);

		$user_pic_name_no = $get_pic_no_no + 1;
		$image_name_new = "vid." . $user_pic_name_no . "." . $image_extension;
		$image_location = "../vid/" . $signed_username . "_video/" . $image_name_new;

		if(rename($post_video, $image_location))
		{

		//updating video in the media table of that user
			$update_photo_table_query = "INSERT INTO " . $signed_username . "_media VALUES('', '', '', '', '" . $image_name_new . "', now(), '" . $post_location ."')";
			$update_photo_table_query_run = mysqli_query($connect_link, $update_photo_table_query);

		//setting post_photo to only name of the pic so that it can be used as photo name while getting post
			$post_video = $image_name_new;
		}
		else
		{
			echo "Something went wrong while transfering video";
		}
	}
	else
	{
		$post_video = null;
	}

//updating the user_post table and adding new row in likes and notification table for that post
	$post_user_pos_query = "INSERT INTO " . $signed_username . "_post VALUES('', '" . $post_textarea . "', '" . $post_photo . "', '" . $post_video . "', '" . $post_location . "', now())";

	if($post_user_pos_query_run = mysqli_query($connect_link, $post_user_pos_query))
	{
		echo 1;
			
	//getting post id of this post
		$get_post_id_query = "SELECT id FROM " . $signed_username . "_post ORDER BY id DESC";
		$get_post_id_query_run = mysqli_query($connect_link, $get_post_id_query);
		$get_post_id_query_run_assoc = mysqli_fetch_assoc($get_post_id_query_run);
		$post_id = $get_post_id_query_run_assoc['id'];

	//adding a new row for that post in likes table
		// $add_post_likes_row_query = "INSERT INTO likes VALUES('', '" . $signed_username . "', '" . $signed_username . "_post_" . $post_id . "', '', now())";
		// $add_post_likes_row_query_run = mysqli_query($connect_link, $add_post_likes_row_query);
			
	//adding a new row for likes of that post in notification table
		$add_post_likes_for_notify_query = "INSERT INTO user_notifications VALUES('', '$signed_username', 'like', '$post_id', '', 'have liked your post', now(), '0')";
		$add_post_likes_for_notify_query_run = mysqli_query($connect_link, $add_post_likes_for_notify_query);

	//adding a new row for comments of that post in notification table
		$add_post_likes_for_notify_query = "INSERT INTO user_notifications VALUES('', '$signed_username', 'comment', '$post_id', '', 'have commented on your post', now(), '0')";
		$add_post_likes_for_notify_query_run = mysqli_query($connect_link, $add_post_likes_for_notify_query);

	}
	else
	{
		echo 'Something went wrong while posting your post';
	}
?>