<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/post_view_style.css">
	<script type="text/javascript" src="js/jquery.js"></script>

	<meta name="viewport" content ="width= device-width, initial-scale= 1">
</head>
<body>

<?php
	include('php/connect_db.php');
	$login_plz = 0;

//checking if the visitor is friend of the user or user himself
	if(isset($_COOKIE['signed_username']))
	{
		$signed_username = $_COOKIE['signed_username'];

		if(isset( $_GET['username']) && isset($_GET['post_id']))
		{
			$username = $_GET['username'];
			$post_id = $_GET['post_id'];
			
		//checking if user is friend
			$check_frnd_query = "SELECT id FROM " . $signed_username . "_info WHERE comp = '" . $username . "'";
			$check_frnd_query_run = mysqli_query($connect_link, $check_frnd_query);
			$check_frnd = mysqli_num_rows($check_frnd_query_run);

			if($username == $signed_username)
			{
				$user_post_access = 1;
			}
			else
			{
				$user_post_access = 0;

				if($check_frnd == 1)
				{
					$user_post_access = 2;
				}
			}

			//echo $username . "<br>" . $post_id . "<br>" . $user_post_access;
		}
		else
		{
			include('css/index.html');
			die();
		}
	}
	else
	{
		$signed_username = null;
		$user_post_access = 0;

		if(isset( $_GET['username']) && isset($_GET['post_id']))
		{
			$username = $_GET['username'];
			$post_id = $_GET['post_id'];
			$user_post_access = 0;
		}
		else
		{
			include('css/index.html');
			die();
		}
		
		$login_plz= 1;
	}

//fetching user_info
	$fetch_user_info_query = "SELECT * FROM users_info WHERE username = '" . $username . "'";
	$fetch_user_info_query_run = mysqli_query($connect_link, $fetch_user_info_query);

	$fetched_users = mysqli_num_rows($fetch_user_info_query_run);

	if($fetched_users > 0)
	{
		$fetch_user_info_assoc = mysqli_fetch_assoc($fetch_user_info_query_run);

		$user_name = $fetch_user_info_assoc['name'];
		$user_username = $fetch_user_info_assoc['username'];
		$user_dp = $fetch_user_info_assoc['dp'];
		
		$dp_location =  "img/". $user_username . "_photo/" . $user_dp;
	}
	else
	{
		include('css/index.html');
		die();
	}
	
//getting the post of the user
	$get_post_query = "SELECT * FROM " . $username . "_post WHERE id = '" . $post_id . "'";
	$get_post_query_run = mysqli_query($connect_link, $get_post_query);

	$fetched_post = mysqli_num_rows($get_post_query_run);

	if($fetched_post > 0)
	{
		$get_post_assoc = mysqli_fetch_assoc($get_post_query_run); 
		
		$get_post_id = $get_post_assoc['id'];
		$get_post_text = $get_post_assoc['text'];
		$get_post_photo = $get_post_assoc['photo'];
		$get_post_video = $get_post_assoc['video'];
		$get_post_location = $get_post_assoc['location'];
		$get_post_time = $get_post_assoc['time'];

	//for getting time passed since post
		$content_timestamps = strtotime($get_post_time);
		$current_time = time();
		$time_spent = $current_time - $content_timestamps;

		$time_in_mins = round($time_spent/60) . " mins";

		$time_in_hrs= "";
		$time_in_days= "";
		$time_in_mnths = "";

		if($time_in_mins>=60)
		{
			$time_in_hrs = round($time_in_mins/60) . " hrs";
			$time_in_mins = "";

			if($time_in_hrs >= 24)
			{
				$time_in_days = round($time_in_hrs/24) . " days";
				$time_in_hrs =  "";
				$time_in_mins = "";

				if($time_in_days>=30)
				{
					$time_in_mnths =  round($time_in_days/30) . " months";
					$time_in_days = "";
					$time_in_hrs =  "";
					$time_in_mins = "";

				}
			}
		}
	//for getting time passed since post

	}
	else
	{
		include('css/index.html');
		die();
	}
?>

<!------displaying the post------>
	<div class="view_post_div">
		<div class="view_post_content">
			<?php
				if($get_post_photo !="")
				{
					echo "<center><img class=\"view_post_image_content\" src=\"img/" . $username . "_photo/" . $get_post_photo ." \" onerror=\"this.onerror=null;this.src='img/photo_placeholder.png';\" /></center>";

				}

				if($get_post_video !="")
				{
					echo "<center><video class=\"view_post_video_content\" controls>
							  <source src=\"vid/".$username, "_video/". $get_post_video."#t=1\" type=\"video/mp4\">
							  Your browser does not support the video tag.
						</video></center>";
				}

				if($get_post_photo =="" && $get_post_video =="")
				{
					echo "<img class=\"view_post_text_content\" src=\"img/post_cover.jpg\">";
				}
				
			?>
		</div>

	<!-------button to show post details---------->
		<button class="view_post_dtls_button">Post Details</button>

	<!--------post info region------>
		<div class="view_post_info">
			<img class="close_icon" src="img/close.png"/>

		<!---diplaying username and dp of the post user------>
			<img class="view_user_dp" src="<?php echo $dp_location; ?>" onerror="this.onerror=null;this.src='img/def_user_dp.jpg';">
			&nbsp
			<span class="view_user_name"><?php echo $user_name; ?></span>
			<br><br>

		<!---------the scroll div of the view post------>
			<div class="view_post_scroll_div">
			<!---displaying post content text if available------>
				<div class="view_post_text_content_info">
					<div class="post_text_content">
						<?php
							if($get_post_text !="")
							{
								echo $get_post_text;
							}
						?>
					</div>
					
				</div>
				<br>

			<!------if no user is logged in------>
				<?php
					if ($user_post_access == 0) 
					{
						echo "<a class=\"header_login_button\" href=\"index.php\">Login / Register</a>";
					}
				?>

			<!------post like and comment button area-------->
				<div class="view_post_like_comment">
					<?php
						if($user_post_access == 1 || $user_post_access == 2)
						{
						//getting like count of a particular post
							$like_post_id = $username . "_post_" . $get_post_id;
							$like_count_query = "SELECT id FROM likes WHERE post_id = '$like_post_id'";
							$like_count_query_run = mysqli_query($connect_link, $like_count_query);
							$like_count = mysqli_num_rows($like_count_query_run);

						//to know if user have liked a particular post or not
							$like_post_id = $username . "_post_" . $get_post_id;
							$user_liked_query = "SELECT id FROM likes WHERE user_name = '$signed_username' && post_id = '$like_post_id'";
							$user_liked_query_run = mysqli_query($connect_link, $user_liked_query);
							$user_liked = mysqli_num_rows($user_liked_query_run);

							if($user_liked >= 1)
							{
								echo "	<span class=\"post_like_text\">unlike</span>
										<img class=\"post_like_button\" src=\"img/like_png.png\"/>";
							}
							else
							{
								echo "	<span class=\"post_like_text\">like</span>
										<img class=\"post_like_button\" src=\"img/like1.png\"/>";
							}


							echo "		<span class=\"post_like_count\">$like_count</span>
										
										<img class=\"post_comment_button\" src=\"img/comment_white.png\"/>";
						}
					?>	
				</div>

				<div class="post_comment_container">
					
				</div>
			</div>
		
		<!---diplaying post time and location of the post------>
			<div class="view_post_footer">
				<?php
						if($get_post_location != "")
						{
							echo "<span class=\"view_post_location\"> at <img class=\"post_location_icon\" src=\"img/location_white.png\" />$get_post_location</span>";
						}
				?>

				<span class="view_post_time">
					<?php
						if($time_in_days <=2)
						{
							echo "$time_in_mnths $time_in_days $time_in_hrs $time_in_mins ago";
						}
						else
						{
							echo date('d M Y', strtotime($get_post_time));
						}
					?>
				</span>
			</div>

		</div>

	</div>

<!-----scripts-------->
	<script type="text/javascript">	
	//on clicking on like button
		$('.post_like_button').click(function()
		{
			var this_post_id = $.trim("<?php echo $get_post_id; ?>");
			var username = $.trim("<?php echo $username; ?>");

			var post_like_text = $('.post_like_text').text();
			//alert(post_like_text);

			if(post_like_text == "like")
			{
				$.post('php/add_like.php', {this_post_id: this_post_id, username: username}, function(data)
				{
					$('.post_like_count').text(data);
					$('.post_like_text').text("unlike");
					$('.post_like_button').attr("src", "img/like_png.png");
				});
			}
			else
			{
				$.post('php/remove_like.php', {this_post_id: this_post_id, username: username}, function(data)
				{			
					$('.post_like_count').text(data);
					$('.post_like_text').text("like");
					$('.post_like_button').attr("src", "img/like1.png");
				});
			}
		});

	//on clicking on like count text of the post
		$('.post_like_count').click(function()
		{
			var username = $.trim("<?php echo $username; ?>");
			var this_post_id = $.trim("<?php echo $get_post_id; ?>");
			
			$.post('php/get_post_like.php', {this_post_id: this_post_id, username: username}, function(e)
			{
				$('.post_comment_container').html(e);
			});	

			$('.post_comment_container').fadeIn(200);
		});

	//on clicking on comment icon of the post
		$('.post_comment_button').click(function()
		{
			var username = $.trim("<?php echo $username; ?>");
			var this_post_id = $.trim("<?php echo $get_post_id; ?>");
			
			$.post('php/get_post_comment.php', {this_post_id: this_post_id, username: username}, function(e)
			{
				$('.post_comment_container').html(e);
			});	

			$('.post_comment_container').fadeIn(200);
		});

	//on clicking on close icon
		$('.close_icon').click(function()
		{
			$('.view_post_info').slideUp(1000);

			$('.view_post_dtls_button').delay(800).fadeIn(500);
		});
		
		$('.view_post_dtls_button').click(function()
		{
			$('.view_post_info').slideDown(1000);
			$('.view_post_dtls_button').fadeOut(200);
		});

	</script>

</body>
</html>
