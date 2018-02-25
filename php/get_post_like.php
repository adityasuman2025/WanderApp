<?php
	include('connect_db.php');

	$this_post_id = $_POST['this_post_id'];
	$username = $_POST['username'];

	if(isset($_COOKIE['signed_username']))
	{
		$signed_username = $_COOKIE['signed_username'];
		
	}
	
	$post_id = $username . "_post_" . $this_post_id;
	$get_post_like_query = "SELECT * FROM likes WHERE post_id = '" . $post_id . "' ORDER BY id DESC";

	if($get_post_like_query_run = mysqli_query($connect_link, $get_post_like_query))
	{
		while($get_post_like_assoc = mysqli_fetch_assoc($get_post_like_query_run))
		{
			$get_post_like_username = $get_post_like_assoc['user_name'];

			$fetch_user_info_query = "SELECT * FROM users_info WHERE username = '" . $get_post_like_username . "'";
			$fetch_user_info_query_run = mysqli_query($connect_link, $fetch_user_info_query);

			$fetched_users = mysqli_num_rows($fetch_user_info_query_run);

			if($fetched_users > 0)
			{
				$fetch_user_info_assoc = mysqli_fetch_assoc($fetch_user_info_query_run);
				$user_name = $fetch_user_info_assoc['name'];
				
				echo "<div class=\"post_liked_user_div\"> <img src=\"img/like_png.png\"/> $user_name</div>";
				
			}
		}

	}
	else
	{
		echo 'Something went wrong while fetching likes.';
	}
?>