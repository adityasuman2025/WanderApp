<!--------header bar------>
<?php
	include('php/header.php');
?>

<?php
	
	if(isset($_GET['username']))
	{
		$username = htmlentities(mysqli_real_escape_string($connect_link, $_GET['username']));

		if(isset($_COOKIE['signed_username']))
		{
			$signed_username = $_COOKIE['signed_username'];

		//checking if this username is blocked by signed user?
			$check_block_query = "SELECT id FROM " . $signed_username . "_info WHERE block = '" . $username . "'";
			$check_block_query_run = mysqli_query($connect_link, $check_block_query);
			$check_block = mysqli_num_rows($check_block_query_run);
			if($check_block >= 1)
			{
				die("<div class=\"blocked_alert\">You have blocked this profile.</div>");
			}

		//checking if this username is blocked by signed user?
			$check_block_query1 = "SELECT id FROM " . $username . "_info WHERE block = '" . $signed_username . "'";
			$check_block_query_run1 = mysqli_query($connect_link, $check_block_query1);
			$check_block1 = mysqli_num_rows($check_block_query_run1);
			if($check_block1 >= 1)
			{
				die("<div class=\"blocked_alert\">This profile has blocked you.</div>");
			}
		}
		else
		{
			$signed_username = null;
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
			$user_bio = $fetch_user_info_assoc['bio'];
			$user_dp = $fetch_user_info_assoc['dp'];
			$user_cover = $fetch_user_info_assoc['cover'];


			$fetch_user_bucket_query = "SELECT bucket FROM " . $username . "_info ORDER BY bucket DESC LIMIT 3";
			$fetch_user_passion_query = "SELECT passion FROM " . $username . "_info ORDER BY passion DESC LIMIT 3";
			$fetch_user_travel_query = "SELECT travel FROM " . $username . "_info ORDER BY travel DESC LIMIT 5";
		}
		else
		{
			die("<br><br><br>you have requested for an unknown page");
		}
	}
	else
	{
		echo "<br><br>";
		include('css/index.html');
		die();
	}
?>

<html>
<head>
	<title><?php echo $username; ?></title>
</head>
<body>
<!----user banner---->
	<div class="user_banner">
		<?php
			$cover_location =  "img/". $username . "_photo/" . $user_cover;
			echo "<img src=\"$cover_location\" onerror=\"this.onerror=null;this.src='img/def_user_cover.jpg';\"/>";
		?>
		<div class="user_name"><?php echo $user_name ?></div>
	</div>

<!---------body div---------->
<div class="body_div">

<!----user option and intro and post---->
	<div class="row option_intro_div">

	<!---------user intro-------->
		<div class="col-xs-12 col-md-3 user_info">

			<div class="user_dp">
				<?php
					$dp_location =  "img/". $user_username . "_photo/" . $user_dp;
					echo "<img src=\"$dp_location\" onerror=\"this.onerror=null;this.src='img/def_user_dp.jpg';\"/>";
				?>
			</div>
			
			<div class="user_intro">
				<div class="user_bio"><?php echo $user_bio ?></div>
			
				<div class="user_bucket">
					<ul>
						<?php
							if($fetch_user_bucket_query_run = mysqli_query($connect_link, $fetch_user_bucket_query))
							{
								while($fetch_user_bucket_assoc = mysqli_fetch_assoc($fetch_user_bucket_query_run))
								{
									$user_bucket = $fetch_user_bucket_assoc['bucket'];

									if($user_bucket !="")
									{
										echo "<li><img src=\"img/bucket.png\"> $user_bucket</li>";
									}
								}
							}
						?>
						
					</ul>
				</div>
				<br>

				<div class="user_passion">
					<ul>
						<?php
							if($fetch_user_passion_query_run = mysqli_query($connect_link, $fetch_user_passion_query))
							{
								while($fetch_user_passion_assoc = mysqli_fetch_assoc($fetch_user_passion_query_run))
								{
									$user_passion = $fetch_user_passion_assoc['passion'];

									if($user_passion != "")
									{
										echo "<li><img src=\"img/passion1.png\"> $user_passion</li>";
									}
											
								}
							}
						?>
						
					</ul>					
				</div>
				
				<div class="user_trip">
					<ul>
						<?php
							if($fetch_user_travel_query_run = mysqli_query($connect_link, $fetch_user_travel_query))
							{
								while($fetch_user_travel_assoc = mysqli_fetch_assoc($fetch_user_travel_query_run))
								{
									$user_travel = $fetch_user_travel_assoc['travel'];

									if($user_travel !="")
									{
										echo "<li><img src=\"img/trip.png\"> $user_travel</li>";
									}
								}
							}
						?>
						
					</ul>
				</div>
			</div>

		</div>

	<!---------user option and post-------->
		<div class="col-xs-12 col-md-9 user_option_post">
			
			<div class="user_option">
				<ul>
					<li class="user_people_button">People</li>
					<li class="user_photo_button">Photos</li>
					<li class="user_video_button">Videos</li>
					<li class="user_about_button">About</li>
				</ul>
			</div>

			<div class="user_post">		
				<?php
					if($username == $signed_username)
					{
						echo "	<div class=\"post_textarea_thumbnail row\">
									<textarea maxlength=\"2500\" class=\"post_textarea col-md-12 col-xs-12\" placeholder=\"write your story\"></textarea>
									<div class=\"post_thumbnail col-md-3 col-xs-3\"></div>
								</div>
								<div class=\"post_option\">
									<span class=\"post_photo\"><img src=\"img/photo.png\"> Photo</span>
									<span class=\"post_video\"><img src=\"img/video.png\"> Video</span>
									<input maxlength=\"50\" class=\"post_location\" placeholder = \"add location\"/>
									<button class=\"post_button\">POST</button>
								</div>";									
					}
					else if(isset($_COOKIE['signed_username']))
					{	
					//checking if the signed user is frnd of user or not
						$check_comp_query = "SELECT id FROM " . $signed_username . "_info WHERE comp = '$username'";
						$check_comp_query_run = mysqli_query($connect_link, $check_comp_query);
						$check_comp = mysqli_num_rows($check_comp_query_run);

					//checking if rqst is already sent to the username
						$check_sent_rqst_query= "SELECT id FROM " . $username . "_info WHERE comp_rqst ='$signed_username'";
						$check_sent_rqst_query_run = mysqli_query($connect_link, $check_sent_rqst_query);
						$check_sent_rqst = mysqli_num_rows($check_sent_rqst_query_run);

					//checking if username has sent rqst to the signed user
						$check_sent_rqst_query1= "SELECT id FROM " . $signed_username . "_info WHERE comp_rqst ='$username'";
						$check_sent_rqst_query_run1 = mysqli_query($connect_link, $check_sent_rqst_query1);
						$check_sent_rqst1 = mysqli_num_rows($check_sent_rqst_query_run1);

						echo "	<div class=\"companion_control_div\">";

							if($check_comp == 1)
							{
								echo "	<button>Message</button><br><br>";
								echo "	<button class=\"remove_comp_button\">Remove Companion</button><br>";
								echo "	<button class=\"block_comp_button\">Block</button><br>";							
							}
							else
							{
								if($check_sent_rqst == 1)
								{
								//means signed user had already sent rqst to the user
									echo "	<button class=\"cancel_rqst_button\">Cancel Request</button><br>";
								}
								else if($check_sent_rqst1 == 1)
								{
								//means user has sent rqst to the signed user
									echo "	<button class=\"accept_user_rqst_button\">Accept Request</button><br>";
									echo "	<button class=\"delete_user_rqst_button\">Delete Request</button><br>";
								}
								else
								{
									echo "	<button class=\"make_comp_button\">Make Companion</button><br>";
								}

								echo "	<button class=\"block_comp_button\">Block</button><br>";							
							}
						
						echo "	</div>";
					}
					else
					{
						echo "<button class=\"post_login_button\">Login / Register</button>";
					}
				?>			
			</div>

		</div>

	</div>

<!------user ajax------>
	<div class="user_ajax_div">
		<div class="user_ajax_close">
			<img src="img/close.png"/>
		</div>

		<div class="user_ajax_content"></div>
	</div>
</div>

<!-----user post---->
	<div class="post_container"></div>
	<br>

	<div class="load_more_post">load more..</div>
	<br><br>

	<button class="close_window">close</button>

<!--------footer------>
	<?php
		//include('php/footer.php');
	?>

<!--------scripts---------->
	<script type="text/javascript">

	/*----top user banner and header bar animation---------*/
		$(window).scroll(function()
		{
			win_pos = $(window).scrollTop();
			$('.user_banner img').css('top', win_pos  + 'px');
		});

	/*-----entering animations-----*/
		$(window).ready(function()
		{
			$('.user_info').addClass('user_info_entry');
			$('.user_option_post').addClass('user_option_post_entry');
		});

		
	/*------on clicking on login header button-------*/
		$('.post_login_button').click(function()
		{
			$(location).attr('href', 'index.php');
		});

	//ajax on user ajax
		$('.user_people_button').click(function()
		{
			var username = "<?php echo $username; ?>";
			$.post('php/user_people.php', {username: username}, function(e)
			{
				$('.user_ajax_content').html(e);
			});

			$('.user_ajax_div').fadeIn(500);
			$('.option_intro_div').fadeOut(0);
			$('.post_container').fadeOut(0);
			$('.load_more_post').fadeOut(0);
		});

		$('.user_photo_button').click(function()
		{
			var username = "<?php echo $username; ?>";
			$.post('php/user_photos.php', {username: username}, function(e)
			{
				$('.user_ajax_content').html(e);
			});

			$('.user_ajax_div').fadeIn(500);
			$('.option_intro_div').fadeOut(0);
			$('.post_container').fadeOut(0);
			$('.load_more_post').fadeOut(0);
		});

		$('.user_video_button').click(function()
		{
			var username = "<?php echo $username; ?>";
			$.post('php/user_videos.php', {username: username}, function(e)
			{
				$('.user_ajax_content').html(e);
			});

			$('.user_ajax_div').fadeIn(500);
			$('.option_intro_div').fadeOut(0);
			$('.post_container').fadeOut(0);
			$('.load_more_post').fadeOut(0);
		});

		$('.user_about_button').click(function()
		{
			var username = "<?php echo $username; ?>";
			$.post('php/user_about.php', {username: username}, function(e)
			{
				$('.user_ajax_content').html(e);
			});

			$('.user_ajax_div').fadeIn(500);
			$('.option_intro_div').fadeOut(0);
			$('.post_container').fadeOut(0);
			$('.load_more_post').fadeOut(0);
		});

		$('.user_ajax_close img').click(function()
		{
			$('.user_ajax_div').fadeOut(0);
			$('.option_intro_div').fadeIn(500);
			$('.post_container').fadeIn(0);
			$('.load_more_post').fadeIn(0);
		})

	//on clicking on remove companion button
		$('.remove_comp_button').click(function()
		{
			var username = "<?php echo $username; ?>";
			var signed_username = "<?php echo $signed_username; ?>";

			var query_to_send = "DELETE FROM " + username + "_info WHERE comp = '" + signed_username + "'";
			$.post('php/change_comp.php', {query_to_send: query_to_send}, function(e)
			{
				if(e == 1)
				{
					var query_to_send = "DELETE FROM " + signed_username + "_info WHERE comp = '" + username + "'";
					$.post('php/change_comp.php', {query_to_send: query_to_send}, function(e)
					{
						if(e == 1)
						{
							location.reload();
						}
						else
						{
							alert('Something went wrong. Try again later.');
						}
					});
				}
				else
				{
					alert('Something went wrong. Try again later.');
				}
			});			
		});

	//on clicking on make companion button
		$('.make_comp_button').click(function()
		{
			var username = "<?php echo $username; ?>";
			var signed_username = "<?php echo $signed_username; ?>";

			var query_to_send = "INSERT INTO " + username + "_info VALUES('', '', '', '', '', '', '" + signed_username + "')";
			$.post('php/change_comp.php', {query_to_send: query_to_send}, function(e)
			{
				if(e == 1)
				{
					location.reload();
				}
				else
				{
					alert('Something went wrong. Try again later.');
				}
			});
		});

	//on clicking on cancel request button
		$('.cancel_rqst_button').click(function()
		{
			var username = "<?php echo $username; ?>";
			var signed_username = "<?php echo $signed_username; ?>";

			var query_to_send = "DELETE FROM " + username + "_info WHERE comp_rqst = '" + signed_username + "'";
			$.post('php/change_comp.php', {query_to_send: query_to_send}, function(e)
			{
				if(e == 1)
				{
					location.reload();
				}
				else
				{
					alert('Something went wrong. Try again later.');
				}
			});
		});

	//on clicking on delete rqst buttoon
		$('.delete_user_rqst_button').click(function()
			{
				var username = "<?php echo $username; ?>";
				var signed_username = "<?php echo $signed_username; ?>";
				
				var query_to_send = "DELETE FROM " + signed_username + "_info WHERE comp_rqst = '" + username + "'";
				$.post('php/change_comp.php', {query_to_send: query_to_send}, function(e)
				{
					if(e == 1)
					{
						location.reload();
					}
					else
					{
						alert('Something went wrong. Try again later.');
					}
				});
			});

	//on clicking in accept rqst buttoon
		$('.accept_user_rqst_button').click(function()
		{
			var username = "<?php echo $username; ?>";
			var signed_username = "<?php echo $signed_username; ?>";

			var query_to_send = "INSERT INTO " + signed_username + "_info VALUES('', '', '', '', '" + username + "', '', '')";
			$.post('php/change_comp.php', {query_to_send: query_to_send}, function(e)
			{
				if(e == 1)
				{
					var query_to_send = "INSERT INTO " + username + "_info VALUES('', '', '', '', '" + signed_username + "', '', '')";
					$.post('php/change_comp.php', {query_to_send: query_to_send}, function(e)
					{
						if(e == 1)
						{
							var query_to_send = "DELETE FROM " + signed_username + "_info WHERE comp_rqst = '" + username + "'";
							$.post('php/change_comp.php', {query_to_send: query_to_send}, function(e)
							{
								if(e == 1)
								{
									location.reload();
								}
								else
								{
									alert('Something went wrong. Try again later.');
								}
							});
						}
						else
						{
							alert('Something went wrong. Try again later.');
						}
					});
				}
				else
				{
					alert('Something went wrong. Try again later.');
				}
			});
		});

	//on clicking on block button
		$('.block_comp_button').click(function()
		{
			var username = "<?php echo $username; ?>";
			var signed_username = "<?php echo $signed_username; ?>";

		//inserting the username into blocklist of signed user
			var query_to_send = "INSERT INTO " + signed_username + "_info VALUES('', '', '', '', '', '" + username + "', '')";
			$.post('php/change_comp.php', {query_to_send: query_to_send}, function(e)
			{
				if(e == 1)
				{
				//deleting the username from the frndlist of signed user
					var query_to_send = "DELETE FROM " + signed_username + "_info WHERE comp = '" + username + "'";
					$.post('php/change_comp.php', {query_to_send: query_to_send}, function(e)
					{
						if(e == 1)
						{
						//deleting the signed user from the frndlist of username
							var query_to_send = "DELETE FROM " + username + "_info WHERE comp = '" + signed_username + "'";
							$.post('php/change_comp.php', {query_to_send: query_to_send}, function(e)
							{
								if(e == 1)
								{
								//deleting the username if signed username has sent rqst
									var query_to_send = "DELETE FROM " + username + "_info WHERE comp_rqst = '" + username + "'";
									$.post('php/change_comp.php', {query_to_send: query_to_send}, function(e)
									{
										if(e == 1)
										{
											location.reload();
										}
										else
										{
											alert('Something went wrong. Try again later.');
										}
									});
								}
								else
								{
									alert('Something went wrong. Try again later.');
								}
							});
						}
						else
						{
							alert('Something went wrong. Try again later.');
						}
					});
				}
				else
				{
					alert('Something went wrong. Try again later.');
				}
			});
		});

	/*-----for posting photo------*/
		$('.post_photo').click(function()
		{
			$('.ajax_loading_bckgrnd').fadeIn(500);
			$('.ajax_loading_div').fadeIn(500);

			var upload_what = "post_pic";
			$.post('php/upload_post_pic_form.php', {upload_what: upload_what}, function(e)
			{
				$('.ajax_content').html(e);
			});
		});

	/*-----for posting video------*/
		$('.post_video').click(function()
		{
			$('.ajax_loading_bckgrnd').fadeIn(500);
			$('.ajax_loading_div').fadeIn(500);

			var upload_what = "post_vid";
			$.post('php/upload_post_vid_form.php', {upload_what: upload_what}, function(e)
			{
				$('.ajax_content').html(e);
			});
		});

	//posting post of the user
		$('.post_button').click(function()
		{
			var post_textarea = $.trim($('.post_textarea').val());
			var post_location = $('.post_location').val();
			var signed_username = "<?php echo $signed_username; ?>";

		//checking if image is uploaded or not
			var post_thumbnail_img_src = $('.post_thumbnail').find('img').attr('src');
			if(post_thumbnail_img_src != undefined)
			{
				var post_photo = post_thumbnail_img_src;
			}
			else
			{
				var post_photo = 0;
			}

		//checking if video is uploaded or not
			var post_thumbnail_video_src = $('.post_thumbnail').find('source').attr('src');
			//alert(post_thumbnail_video_src);

			if(post_thumbnail_video_src != undefined)
			{
				var post_video = post_thumbnail_video_src;
			}
			else
			{
				var post_video = 0;
			}

			if(post_textarea == '' && post_video == 0 && post_photo == 0)
			{

			}
			else
			{
				$.post('php/post_user_post.php', {signed_username: signed_username, post_textarea: post_textarea, post_photo: post_photo, post_video: post_video, post_location: post_location}, function(e)
				{
					//alert(e);
					if(e == 1)
					{
						location.reload();
					}
					else
					{
						$('.post_textarea').val('Something went wrong while posting your post');
					}
				});
			}
		});

	//getting total number of post of the user
		var username = $.trim("<?php echo $username; ?>");
		var query_to_send = "SELECT id FROM " + username + "_post";

		start = 0;
		limit = 10;
		org_limit = 10;

		$.post('php/get_user_post_count.php', {query_to_send: query_to_send}, function(data)
		{
			user_post_count = data;
		});

	/*----for generatng load more for user post---*/
		var username = "<?php echo $username; ?>";
		var query_to_send = "SELECT * FROM " + username + "_post ORDER BY id DESC LIMIT " + start + ", " + limit;
		
		$.post('php/get_user_post.php', {query_to_send: query_to_send, username: username}, function(e)
		{
			$('.post_container').html(e);

		//if initially total no of div is less than limit then load more is not visible
			if(user_post_count <= limit)
			{
				$('.load_more_post').fadeOut(0);
			}
			else
			{
				$('.load_more_post').fadeIn(0);
			}
		
			post_div_count = $('.post_container').find('.post_div').length;
			
		});

	/*-------on clicking on load more of user post-----------*/
		$('.load_more_post').click(function()
		{
			limit = limit + org_limit;

			var username = "<?php echo $username; ?>";
			var query_to_send = "SELECT * FROM " + username + "_post ORDER BY id DESC LIMIT " + start + ", " + limit;
			
			$.post('php/get_user_post.php', {query_to_send: query_to_send, username: username}, function(e)
			{
				$('.post_container').html(e);
				user_post_content_no = $('.post_container .post_div').length;

				$('.post_container .post_div').addClass('post_div_entry');

				if(user_post_content_no >= user_post_count)
				{
					$('.load_more_post').fadeOut(0);
				}
			});

			if(user_post_content_no >= user_post_count)
			{
				$('.load_more_post').fadeOut(0);
			}
		});

	/*----entering animation of post divs-------*/
		$(window).scroll(function()
		{
			var post_container_pos = $('.post_container').offset().top/1.7;
			var scroll_pos = $(this).scrollTop();

			if(scroll_pos > post_container_pos)
			{
				$('.post_div').addClass('post_div_entry');
			}
		});
		
	</script>

</body>
</html>
