<?php
	if(isset($_COOKIE['signed_username']))
	{
	//--------header bar-----
		include('php/header.php');
	
	//getting infos of the signed user
		$signed_username = $_COOKIE['signed_username'];

	//fetching user_info
		$fetch_user_info_query = "SELECT * FROM users_info WHERE username = '" . $signed_username . "'";
		$fetch_user_info_query_run = mysqli_query($connect_link, $fetch_user_info_query);

		$fetched_users = mysqli_num_rows($fetch_user_info_query_run);

		if($fetched_users > 0)
		{
			$fetch_user_info_assoc = mysqli_fetch_assoc($fetch_user_info_query_run);

			$user_name = $fetch_user_info_assoc['name'];
			$user_username = $fetch_user_info_assoc['username'];
			$user_bio = $fetch_user_info_assoc['bio'];
			$user_dp = $fetch_user_info_assoc['dp'];
			$user_cover = $fetch_user_info_assoc['cover'];
		}
		else
		{
			die("<br><br><br>you have requested for an unknown page");
		}
	}
	else
	{
		include('index.php');
		die();
	}
?>

<html>
<head>
	<title>Home</title>
</head>
<body>

<!----travel tool div------>
	<div class="travel_tool_div">
		<div class="travel_tool_from">
			<p class="travel_tool_header">Travel Guide</p>
			<input type="text" class="place_input" placeholder="search places"/>
			<br>
			<input type="submit" value="search" class="place_search_button">
		</div>
		
		<div class="travel_tool_searches">
		<!---------user previous seraches------>
			<p class="travel_tool_header">Your Searched Places</p>
			<div class="last_searched_div">
				<?php
					$get_prev_searches_query = "SELECT searched_places FROM user_travel_searches WHERE searched_by = '$signed_username' ORDER BY id DESC LIMIT 10";
					$get_prev_searches_query_run = mysqli_query($connect_link, $get_prev_searches_query);
					while ($get_prev_searches_assoc = mysqli_fetch_assoc($get_prev_searches_query_run))
					{
						$get_prev_searches = $get_prev_searches_assoc['searched_places'];
						echo "<a href=\"#\">$get_prev_searches</a><br>";
					}
				?>
			</div>

		<!---------trending seraches------>
			<br>
			<p class="travel_tool_header">Most Searched Places</p>
			<div class="trend_searched_div">
				<?php
					$get_trend_searches_query = "SELECT searched_places, count(*) as searched_count FROM user_travel_searches GROUP BY searched_places ORDER BY searched_count DESC";
					$get_trend_searches_query_run = mysqli_query($connect_link, $get_trend_searches_query);
					while ($get_trend_searches_assoc = mysqli_fetch_assoc($get_trend_searches_query_run))
					{
						$get_trend_searches_place = $get_trend_searches_assoc['searched_places'];
						$get_trend_searches_count = $get_trend_searches_assoc['searched_count'];
						echo "<a href=\"#\">$get_trend_searches_place</a><br>";
					}
				?>
			</div>

		</div>
		
	</div>

<!----companion suggestion div------>
	<div class="comp_sug_div">
		
	</div>

<!---------feed container------------>
	<div class="feed_container">
		<?php
		//deleting previous feed entry of the signed user in the users_feed table
			$delete_prev_feed = "DELETE FROM users_feed WHERE feed_of = '$signed_username'";
			$delete_prev_feed_query_run = mysqli_query($connect_link, $delete_prev_feed);


		//getting the companions of the signed user
			$get_comp_query = "SELECT comp FROM " . $signed_username . "_info WHERE comp !=''";
			$get_comp_query_run = mysqli_query($connect_link, $get_comp_query);

			while($get_comp_assoc = mysqli_fetch_assoc($get_comp_query_run))
			{
				$get_comp =  $get_comp_assoc['comp'];

				$current_timestamps = time();
				$time_subs = 7 * 86400;
				$wanted_timestamps =  time() - $time_subs;
				$wanted_time = gmdate("Y-m-d H:i:s", $wanted_timestamps);
				
			 //getting the posts of that companion whose which is posted within last 7 days
				$get_comp_post_query = "SELECT id, time FROM " . $get_comp . "_post WHERE time >= '$wanted_time'";
				$get_comp_post_query_run = mysqli_query($connect_link, $get_comp_post_query);
				while($get_comp_post_assoc = mysqli_fetch_assoc($get_comp_post_query_run))
				{
					$post_by = $get_comp;
					$post_id = $get_comp_post_assoc['id'];
					$post_time =  $get_comp_post_assoc['time'];

				//inserting those posts into the feed table
					$insert_feed_query = "INSERT INTO users_feed VALUES('', '$signed_username', '$post_by', '$post_id', '$post_time')";
					$insert_feed_query_run = mysqli_query($connect_link, $insert_feed_query);
				}
			}
		?>

		<?php
		//-----------fetching those posts------>
	
			$fetch_feed_query = "SELECT * FROM users_feed WHERE feed_of = '$signed_username' ORDER BY post_time DESC";
			$fetch_feed_query_run = mysqli_query($connect_link, $fetch_feed_query);
			
			while($fetch_feed_assoc = mysqli_fetch_assoc($fetch_feed_query_run))
			{
				$fetch_feed_post_of = $fetch_feed_assoc['post_by'];
				$fetch_feed_post_id = $fetch_feed_assoc['post_id'];
				
			//fetching info of the companion whose post os this
				$fetch_user_info_query = "SELECT * FROM users_info WHERE username = '" . $fetch_feed_post_of . "'";
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
					
			//showing those posts
				$show_feed_query = "SELECT * FROM " . $fetch_feed_post_of . "_post WHERE id = '$fetch_feed_post_id'";
				$show_feed_query_run = mysqli_query($connect_link, $show_feed_query);
				$show_feed_assoc = mysqli_fetch_assoc($show_feed_query_run);

				$get_post_id = $show_feed_assoc['id'];
				$get_post_text = $show_feed_assoc['text'];
				$get_post_photo = $show_feed_assoc['photo'];
				$get_post_video = $show_feed_assoc['video'];
				$get_post_location = $show_feed_assoc['location'];
				$get_post_time = $show_feed_assoc['time'];

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

			//displaying posts
				echo "<div class=\"feed_post_div\">
						<div class=\"post_text_container\">
							<div class=\"post_user_dp_name_mob\">
								<img class=\"post_dp_icon\" src=\"$dp_location\" onerror=\"this.onerror=null;this.src='img/def_user_dp.jpg';\"/>&nbsp $user_name";
								
								if($get_post_location != "")
								{
									echo "<span> at <img class=\"post_location_icon\" src=\"img/location.png\" />$get_post_location</span>";
								}
				
					echo 	"</div>

							<div post_by = \"$user_username\" class=\"post_content_container\">";

								if($get_post_photo !="")
								{
									echo "<center><img class=\"post_image_content\" src=\"img/" . $user_username . "_photo/" . $get_post_photo ." \" onerror=\"this.onerror=null;this.src='img/photo_placeholder.png';\" /></center>";
								}

								if($get_post_video !="")
								{
									echo "<center><video class=\"post_video_content\" controls>
											  <source src=\"vid/".$user_username, "_video/". $get_post_video."#t=1\" type=\"video/mp4\">
											  Your browser does not support the video tag.
										</video></center>";
								}

								if($get_post_text !="")
								{
									echo "<div class=\"post_text_content\">$get_post_text</div>";									
								}
								
				echo "		</div>";

							echo "	<div class=\"post_like_comment_button\">";

								//getting like count of a particular post
									$like_post_id = $user_username . "_post_" . $get_post_id;
									$like_count_query = "SELECT id FROM likes WHERE post_id = '$like_post_id'";
									$like_count_query_run = mysqli_query($connect_link, $like_count_query);
									$like_count = mysqli_num_rows($like_count_query_run);

								//to know if user have liked a particular post or not
									$like_post_id = $user_username . "_post_" . $get_post_id;
									$user_liked_query = "SELECT id FROM likes WHERE user_name = '$signed_username' && post_id = '$like_post_id'";
									$user_liked_query_run = mysqli_query($connect_link, $user_liked_query);
									$user_liked = mysqli_num_rows($user_liked_query_run);

									if($user_liked >= 1)
									{
										echo "	<span class=\"post_like_text\">unlike</span>
												<img class=\"post_like_button\" post_id = \"$get_post_id\" post_by = \"$user_username\" like_text = \"unlike\" src=\"img/like_png.png\"/>";
									}
									else
									{
										echo "	<span class=\"post_like_text\">like</span>
												<img post_id = \"$get_post_id\" post_by = \"$user_username\" class=\"post_like_button\" like_text = \"like\" src=\"img/like1.png\"/>";
									}


								echo "		<span post_by = \"$user_username\" class=\"post_like_count\">$like_count</span>
											&emsp;

											<img post_by = \"$user_username\" class=\"post_comment_button\" src=\"img/comment.png\"/>";

								echo "		&nbsp &nbsp
											<span class=\"post_time\">";
											if($time_in_days <=2)
											{
												echo "$time_in_mnths $time_in_days $time_in_hrs $time_in_mins ago";
											}
											else
											{
												echo date('d M Y', strtotime($get_post_time));
											}

								echo "		</span>";

							echo"	</div>";
							
				
				echo	"</div>

						<div class=\"post_comment_container\">
							<span class=\"post_id\">
								$get_post_id
							</span>
							<div class=\"post_like_comment_container\"></div>
						</div>
					</div>";
				
			}	
		?>
		 
	</div>
<!----end of feed container------>

	<script>
	//on clicking on like button
		$('.post_like_button').click(function()
		{
			// var this_post_id = $(this).attr('post_id');
			// var post_by = $(this).attr('post_by');
			// var post_like_text = $(this).attr('like_text');
			// alert(post_by);

			var this_post = $(this).parent().parent().parent();
			var this_post_id = $.trim(this_post.find('.post_id').text());
			var username =  $(this).attr('post_by');
			
			var post_like_text = this_post.find('.post_like_text').text();
			
			if(post_like_text == "like")
			{
				$.post('php/add_like.php', {this_post_id: this_post_id, username: username}, function(data)
				{
					this_post.find('.post_like_count').text(data);
					this_post.find('.post_like_text').text("unlike");
					this_post.find('.post_like_button').attr("src", "img/like_png.png");
				});
			}
			else
			{
				$.post('php/remove_like.php', {this_post_id: this_post_id, username: username}, function(data)
				{			
					this_post.find('.post_like_count').text(data);
					this_post.find('.post_like_text').text("like");
					this_post.find('.post_like_button').attr("src", "img/like1.png");
				});
			}
		});

	//on clicking on like count text of the post
		$('.post_like_count').click(function()
		{
			var this_post = $(this).parent().parent().parent();
			var username =  $.trim($(this).attr('post_by'));
			var this_post_id = $.trim(this_post.find('.post_id').text());
			
			$.post('php/get_post_like.php', {this_post_id: this_post_id, username: username}, function(e)
			{
				this_post.find('.post_like_comment_container').html(e);
			});	
			
			this_post.find('.post_comment_container').fadeIn(500);
		});	

	//on clicking on comment icon of the post
		$('.post_comment_button').click(function()
		{
			var this_post = $(this).parent().parent().parent();
			var username =  $.trim($(this).attr('post_by'));
			var this_post_id = $.trim(this_post.find('.post_id').text());
			
			$.post('php/get_post_comment.php', {this_post_id: this_post_id, username: username}, function(e)
			{
				this_post.find('.post_like_comment_container').html(e);
			});	
			
			this_post.find('.post_comment_container').fadeIn(500);
		});

	//on clicking on post //opening the post 
		$('.post_content_container').click(function()
		{
			var username =  $.trim($(this).attr('post_by'));
			var this_post = $(this).parent().parent();
			var this_post_id = $.trim(this_post.find('.post_id').text());

			//alert(signed_username);
			window.location.href = "post_view.php?username=" + username + "&post_id=" + this_post_id;
		});

	//when feed container is empty
		if($.trim($('.feed_container').text()) == '')
		{
			$('.feed_container').text('it seems that your companions have gone lazy.').css('text-align', 'center').css('font-size', '135%');	
		}

	//on clicking on search button of travel tool
		$('.place_search_button').click(function()
		{
			var signed_username  = "<?php echo $signed_username; ?>";
			var place_input = $.trim($('.place_input').val().toLowerCase());
			var place_input_length = place_input.length;

			var letters = /^[a-zA-Z &]+$/;
			if(!place_input.match(letters))
			{
				$('.warn_box').text("Please enter a valid place");
				$('.warn_box').css('background', 'red');
				$('.warn_box').fadeIn(200).delay(2000).fadeOut(200);
			}
			else
			{
				if(place_input_length >=3)
				{
					var query_to_send = "INSERT INTO user_travel_searches VALUES('', '" + signed_username + "', '" + place_input + "', now())";

					$.post('php/change_setting.php', {query_to_send: query_to_send}, function(data)
					{
						if(data == 0)
						{
							$('.warn_box').text("Something went wrong while showing your result");
							$('.warn_box').css('background', 'red');
							$('.warn_box').fadeIn(200).delay(2000).fadeOut(200);
						}
					});
				}
				else
				{
					$('.warn_box').text("Please enter a valid place");
					$('.warn_box').css('background', 'red');
					$('.warn_box').fadeIn(200).delay(2000).fadeOut(200);
				}
			}
		});
	</script>

</body>
</html>