<!--------header bar------>
<?php
	include('php/header.php');
?>

<?php
	if(isset($_COOKIE['signed_username']))
	{
		$username = $_COOKIE['signed_username'];

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

			$user_sex = $fetch_user_info_assoc['sex'];
			$user_dob = $fetch_user_info_assoc['dob'];
			$user_address = $fetch_user_info_assoc['address'];
			$user_language = $fetch_user_info_assoc['language'];
			$user_website = $fetch_user_info_assoc['website'];
			$user_about = $fetch_user_info_assoc['about'];
			$user_nickname = $fetch_user_info_assoc['nick_name'];

			$fetch_user_bucket_query = "SELECT bucket FROM " . $username . "_info WHERE bucket !='' ORDER BY id";
			$fetch_user_passion_query = "SELECT passion FROM " . $username . "_info WHERE passion !='' ORDER BY id";
			$fetch_user_travel_query = "SELECT travel FROM " . $username . "_info WHERE travel !='' ORDER BY id";
		}
		else
		{
			die("<br><br><br>you have requested for an unknown page");
		}
	}
	else
	{
		include('css/index.html');
		die();
	}
?>

<html>
<head>
	<title>Settings</title>
	<style type="text/css">
		.body_div
		{
			box-shadow: 0px 0px 1px grey;
		}
	</style>
</head>
<body>

<!----user banner---->
	<div class="user_banner">
		<?php
			$cover_location =  "img/". $username . "_photo/" . $user_cover;
			echo "<img src=\"$cover_location\" onerror=\"this.onerror=null;this.src='img/def_user_cover.jpg';\"/>";
		?>
		<span class="change_cover">Change Cover Photo</span>
		<div class="user_name"><?php echo $user_name ?></div>
	</div>

<!---------body div-------->
<div class="body_div">
	
<!------user about page-------->
	<div class="user_about_div">
		<div class="row user_about">

		<!------about tab and dp-------->
			<div class="col-xs-12 col-md-3 user_dp_tab_div">
				<div class="user_dp">
					<?php
						$dp_location =  "img/". $username . "_photo/" . $user_dp;
						echo "<img src=\"$dp_location\" onerror=\"this.onerror=null;this.src='img/def_user_dp.jpg';\"/>";
					?>
					<span class="change_dp">Change Profile Photo</span>
				</div>

				<div class="user_tab">
					<ul>
						<li class="user_about_about_button">About</li>
						<li class="user_about_general_button">General</li>
					</ul>
				</div>
			</div>

		<!------selected tab display-------->
			<div class="col-xs-12 col-md-9 user_about_selected_tab">

			<!------about button div-->
				<div class="user_about_setting">
					<h3>About</h3>

					<span class="about_title">Name </span> 
					<span class="setting_name_old"><?php echo $user_name; ?></span>
					<button class="setting_name_change_button"><img src="img/edit.png" /></button>
					<br>
					<input maxlength="30" type="text" pattern="[a-zA-Z0-9-]+" class="setting_name_input" placeholder="Enter Name" required>
					<button class="setting_name_done_button">Done</button>
					<br><br>

					<span class="about_title">Bio </span> 
					<span class="setting_bio_old"><?php echo $user_bio; ?></span>
					<button class="setting_bio_change_button"><img src="img/edit.png" /></button>
					<br>
					<textarea maxlength="100" class="setting_bio_input"></textarea>
					<button class="setting_bio_done_button">Done</button>
					<br><br>

					<span class="about_title">About </span> 
					<span class="setting_about_old"><?php echo $user_about; ?></span>
					<button class="setting_about_change_button"><img src="img/edit.png" /></button>
					<br>
					<textarea maxlength="1000" class="setting_about_input"></textarea>
					<button class="setting_about_done_button">Done</button>
					<br><br>

					<span class="about_title">Nick Name </span> 
					<span class="setting_nick_old"><?php echo $user_nickname; ?></span>
					<button class="setting_nick_change_button"><img src="img/edit.png" /></button>
					<br>
					<input type="text" maxlength="20" class="setting_nick_input" placeholder="Enter Nick Name">
					<button class="setting_nick_done_button">Done</button>
					<br><br>

					<span class="about_title">Sex </span> 
					<span class="setting_sex_old"><?php echo $user_sex; ?></span>
					<button class="setting_sex_change_button"><img src="img/edit.png" /></button>
					<br>
					<select class="setting_sex_input">
						<option value="Male">Male</option>
						<option value="Female">Female</option>
						<option value="Other">Other</option>
					</select>
					<button class="setting_sex_done_button">Done</button>
					<br><br>

					<span class="about_title">Date Of Birth </span> 
					<span class="setting_dob_old">
						<?php 
							echo date("d M Y", strtotime($user_dob));
							//echo $user_dob; 
						?>
								
					</span>
					<button class="setting_dob_change_button"><img src="img/edit.png" /></button>
					<br>
					<input type="date" class="setting_dob_input"/>
					<button class="setting_dob_done_button">Done</button>
					<br><br>

					<span class="about_title">Language </span> 
					<span class="setting_lang_old"><?php echo $user_language; ?></span>
					<button class="setting_lang_change_button"><img src="img/edit.png" /></button>
					<br>
					<input type="text" maxlength="100" class="setting_lang_input" placeholder="Enter Language">
					<button class="setting_lang_done_button">Done</button>
					<br><br>

					<span class="about_title">Website </span> 
					<span class="setting_web_old"><?php echo $user_website; ?></span>
					<button class="setting_web_change_button"><img src="img/edit.png" /></button>
					<br>
					<input maxlength="100" type="text" class="setting_web_input" placeholder="Enter Website">
					<button class="setting_web_done_button">Done</button>
					<br><br>

					<span class="about_title">Address </span> 
					<span class="setting_address_old"><?php echo $user_address; ?></span>
					<button class="setting_address_change_button"><img src="img/edit.png" /></button>
					<br>
					<input maxlength="1000" type="text" class="setting_address_input" placeholder="Enter Address">
					<button class="setting_address_done_button">Done</button>
					<br><br><br><br>

				</div>

			<!-----general button div---->
				<div class="user_general_setting">

				<!----bucket list---->
					<h3>Bucket List</h3>
					<div class="user_bucket">
						<ul>
							<?php
								if($fetch_user_bucket_query_run = mysqli_query($connect_link, $fetch_user_bucket_query))
								{
									$fetch_user_bucket_num_rows = mysqli_num_rows($fetch_user_bucket_query_run);
									if($fetch_user_bucket_num_rows == 0)
									{
										echo "no bucket list found at the moment";
									}
									else
									{
										while($fetch_user_bucket_assoc = mysqli_fetch_assoc($fetch_user_bucket_query_run))
										{
											$user_bucket = $fetch_user_bucket_assoc['bucket'];

											if($user_bucket !="")
											{
												echo "<li><img src=\"img/bucket.png\"> <span> $user_bucket</span> <button class=\"setting_bucket_change_button\"><img src=\"img/delete.png\" /></button></li>";
											}
											
										}
									}
									
								}
							?>
						</ul>

						<br>
						<button class="setting_bucket_add_button">Add More</button>
						<input type="text" maxlength="100" class="setting_bucket_input" placeholder="Add Bucket List">
						<button class="setting_bucket_done_button">Done</button>
						<br><br>
					</div>

				<!----passion---->
					<h3>Passion or Speciality</h3>
					<div class="user_passion">
						<ul>
							<?php
								if($fetch_user_passion_query_run = mysqli_query($connect_link, $fetch_user_passion_query))
								{
									$fetch_user_passion_num_rows = mysqli_num_rows($fetch_user_passion_query_run);
									if($fetch_user_passion_num_rows == 0)
									{
										echo "no passion or speciality found at the moment";
									}
									else
									{
										while($fetch_user_passion_assoc = mysqli_fetch_assoc($fetch_user_passion_query_run))
										{
											$user_passion = $fetch_user_passion_assoc['passion'];

											if($user_passion != "")
											{
												echo "<li><img src=\"img/passion1.png\"> <span> $user_passion</span> <button class=\"setting_passion_change_button\"><img src=\"img/delete.png\" /></button></li>";
											}
											
										}
									}
								}
							?>
						</ul>

						<br>
						<button class="setting_passion_add_button">Add More</button>
						<input maxlength="100" type="text" class="setting_passion_input" placeholder="Add Passion">
						<button class="setting_passion_done_button">Done</button>
						<br><br>

					</div>

				<!----trips---->
					<h3>Trips</h3>
					<div class="user_trip" style="text-align: left;">
						<ul>
							<?php
								if($fetch_user_travel_query_run = mysqli_query($connect_link, $fetch_user_travel_query))
								{
									$fetch_user_travel_num_rows = mysqli_num_rows($fetch_user_travel_query_run);
									if($fetch_user_travel_num_rows == 0)
									{
										echo "no trips found at the moment";
									}
									else
									{
										while($fetch_user_travel_assoc = mysqli_fetch_assoc($fetch_user_travel_query_run))
										{
											$user_travel = $fetch_user_travel_assoc['travel'];

											if($user_travel !="")
											{
												echo "<li><img src=\"img/trip.png\"> <span> $user_travel</span> <button class=\"setting_trip_change_button\"> <img src=\"img/delete.png\" /></button></li>";

											}
											
										}
									}
								}
							?>
							
						</ul>

						<br>
						<button class="setting_trip_add_button">Add More</button>
						<input maxlength="100" type="text" class="setting_trip_input" placeholder="Add Trip">
						<button class="setting_trip_done_button">Done</button>
						<br><br>

					</div>

				</div>

			</div>
		</div>
	</div>

</div>

<!-----scripts---->
	<script type="text/javascript">

	/*----top user banner animation---------*/
		$(window).scroll(function()
		{
			win_pos = $(window).scrollTop();
			$('.user_banner img').css('top', win_pos  + 'px');
		})

	/*-----for uploading dp------*/
		$('.change_dp').click(function()
		{
			$('.ajax_loading_bckgrnd').fadeIn(500);
			$('.ajax_loading_div').fadeIn(500);

			var upload_what = "dp";
			$.post('php/upload_pic_form.php', {upload_what: upload_what}, function(e)
			{
				$('.ajax_content').html(e);
			});
		});

	/*-----for uploading cover------*/
		$('.change_cover').click(function()
		{
			$('.ajax_loading_bckgrnd').fadeIn(500);
			$('.ajax_loading_div').fadeIn(500);

			var upload_what = "cover";
			$.post('php/upload_pic_form.php', {upload_what: upload_what}, function(e)
			{
				$('.ajax_content').html(e);
			});
		});

	//for switching between tabs
		$('.user_about_setting').fadeIn(0);
		$('.user_about_about_button').css('background', '#00cc44');

		$('.user_about_about_button').click(function()
		{
			$('.user_about_setting').fadeIn(500);
			$('.user_general_setting').fadeOut(0);

			$(this).css('background', '#00cc44');
			$('.user_about_general_button').css('background', 'grey');
		});

		$('.user_about_general_button').click(function()
		{
			$('.user_general_setting').fadeIn(500);
			$('.user_about_setting').fadeOut(0);

			$(this).css('background', '#00cc44');
			$('.user_about_about_button').css('background', 'grey');
		});
	
	/*----for changing name------*/
		$('.setting_name_change_button').click(function()
		{
			$('.setting_name_change_button').fadeOut(0);
			$('.setting_name_old').fadeOut(0);
			$('.setting_name_input').fadeIn(0);
			$('.setting_name_done_button').fadeIn(0);

			var username = "<?php echo $username; ?>";

			$('.setting_name_done_button').click(function()
			{
				var setting_name_input =  $.trim($('.setting_name_input').val());

				var letters = /^[0-9a-zA-Z ]+$/;
				if(!setting_name_input.match(letters))
				{
					var setting_name_input = "";
				}

				if(setting_name_input == '' || setting_name_input.length < 5)
				{
					$('.setting_name_input').val('Please enter a valid name');
				}
				else
				{
					var query_to_send = "UPDATE users_info SET name = '" + setting_name_input + "' WHERE username = '" + username + "'";
					$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
					{
						if(e=='1')
						{
							location.reload();
						}
						else
						{
							alert('Something went wrong');
						}
					});
				}
			});
		
		});

	/*----for changing bio------*/
		$('.setting_bio_change_button').click(function()
		{
			$('.setting_bio_change_button').fadeOut(0);
			$('.setting_bio_old').fadeOut(0);
			$('.setting_bio_input').fadeIn(0);
			$('.setting_bio_done_button').fadeIn(0);

			var username = "<?php echo $username; ?>";

			$('.setting_bio_done_button').click(function()
			{
				var setting_bio_input =  $.trim($('.setting_bio_input').val());

				var letters = /^[0-9a-zA-Z .,@&]+$/;
				if(!setting_bio_input.match(letters))
				{
					var setting_bio_input = "";
				}

				if(setting_bio_input == '')
				{
					$('.setting_bio_input').val('Please enter a valid bio');
				}
				else
				{
					var query_to_send = "UPDATE users_info SET bio = '" + setting_bio_input + "' WHERE username = '" + username + "'";
					$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
					{
						if(e=='1')
						{
							location.reload();
						}
						else
						{
							alert('Something went wrong');
						}
					});
				}
			});
		
		});

	/*----for changing about------*/
		$('.setting_about_change_button').click(function()
		{
			$('.setting_about_change_button').fadeOut(0);
			$('.setting_about_old').fadeOut(0);
			$('.setting_about_input').fadeIn(0);
			$('.setting_about_done_button').fadeIn(0);

			var username = "<?php echo $username; ?>";

			$('.setting_about_done_button').click(function()
			{
				var setting_about_input =  $.trim($('.setting_about_input').val());

				var letters = /^[0-9a-zA-Z .,@&]+$/;
				if(!setting_about_input.match(letters))
				{
					var setting_about_input = "";
				}

				if(setting_about_input == '')
				{
					$('.setting_about_input').val('Enter about yourself');
				}
				else
				{
					var query_to_send = "UPDATE users_info SET about = '" + setting_about_input + "' WHERE username = '" + username + "'";
					$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
					{
						if(e=='1')
						{
							location.reload();
						}
						else
						{
							alert('Something went wrong');
						}
					});
				}
			});
		
		});

	/*----for changing nick name------*/
		$('.setting_nick_change_button').click(function()
		{
			$('.setting_nick_change_button').fadeOut(0);
			$('.setting_nick_old').fadeOut(0);
			$('.setting_nick_input').fadeIn(0);
			$('.setting_nick_done_button').fadeIn(0);

			var username = "<?php echo $username; ?>";

			$('.setting_nick_done_button').click(function()
			{
				var setting_nick_input =  $.trim($('.setting_nick_input').val());

				var letters = /^[0-9a-zA-Z ]+$/;
				if(!setting_nick_input.match(letters))
				{
					var setting_nick_input = "";
				}
				
				if(setting_nick_input == '')
				{
					$('.setting_nick_input').val('Please enter a valid nick name');
				}
				else
				{
					var query_to_send = "UPDATE users_info SET nick_name = '" + setting_nick_input + "' WHERE username = '" + username + "'";
					$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
					{
						if(e=='1')
						{
							location.reload();
						}
						else
						{
							alert('Something went wrong');
						}
					});
				}
			});
		
		});

	/*----for changing sex------*/
		$('.setting_sex_change_button').click(function()
		{
			$('.setting_sex_change_button').fadeOut(0);
			$('.setting_sex_old').fadeOut(0);
			$('.setting_sex_input').fadeIn(0);
			$('.setting_sex_done_button').fadeIn(0);

			var username = "<?php echo $username; ?>";

			$('.setting_sex_done_button').click(function()
			{
				var setting_sex_input =  $.trim($('.setting_sex_input').val());

				var letters = /^[0-9a-zA-Z]+$/;
				if(!setting_sex_input.match(letters))
				{
					var setting_sex_input = "";
				}

				if(setting_sex_input == '')
				{
					$('.setting_sex_input').val('Please enter a valid nick name');
				}
				else
				{
					var query_to_send = "UPDATE users_info SET sex = '" + setting_sex_input + "' WHERE username = '" + username + "'";
					$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
					{
						if(e=='1')
						{
							location.reload();
						}
						else
						{
							alert('Something went wrong');
						}
					});
				}
			});
		
		});

	/*----for changing dob------*/
		$('.setting_dob_change_button').click(function()
		{
			$('.setting_dob_change_button').fadeOut(0);
			$('.setting_dob_old').fadeOut(0);
			$('.setting_dob_input').fadeIn(0);
			$('.setting_dob_done_button').fadeIn(0);

			var username = "<?php echo $username; ?>";

			$('.setting_dob_done_button').click(function()
			{
				var setting_dob_input =  $.trim($('.setting_dob_input').val());

				var letters = /^[0-9a-zA-Z -]+$/;
				if(!setting_dob_input.match(letters))
				{
					var setting_dob_input = "";
				}

				if(setting_dob_input == '')
				{
					$('.setting_dob_input').val('Please enter a valid nick name');
				}
				else
				{
					var query_to_send = "UPDATE users_info SET dob = '" + setting_dob_input + "' WHERE username = '" + username + "'";
					$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
					{
						if(e=='1')
						{
							location.reload();
						}
						else
						{
							alert('Something went wrong');
						}
					});
				}
			});
		
		});

	/*----for changing language------*/
		$('.setting_lang_change_button').click(function()
		{
			$('.setting_lang_change_button').fadeOut(0);
			$('.setting_lang_old').fadeOut(0);
			$('.setting_lang_input').fadeIn(0);
			$('.setting_lang_done_button').fadeIn(0);

			var username = "<?php echo $username; ?>";

			$('.setting_lang_done_button').click(function()
			{
				var setting_lang_input =  $.trim($('.setting_lang_input').val());

				var letters = /^[0-9a-zA-Z, ]+$/;
				if(!setting_lang_input.match(letters))
				{
					var setting_lang_input = "";
				}

				if(setting_lang_input == '')
				{
					$('.setting_lang_input').val('Please enter a valid nick name');
				}
				else
				{
					var query_to_send = "UPDATE users_info SET language = '" + setting_lang_input + "' WHERE username = '" + username + "'";
					$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
					{
						if(e=='1')
						{
							location.reload();
						}
						else
						{
							alert('Something went wrong');
						}
					});
				}
			});
		
		});

	/*----for changing website------*/
		$('.setting_web_change_button').click(function()
		{
			$('.setting_web_change_button').fadeOut(0);
			$('.setting_web_old').fadeOut(0);
			$('.setting_web_input').fadeIn(0);
			$('.setting_web_done_button').fadeIn(0);

			var username = "<?php echo $username; ?>";

			$('.setting_web_done_button').click(function()
			{
				var setting_web_input =  $.trim($('.setting_web_input').val());

				var letters = /^[0-9a-zA-Z._-]+$/;
				if(!setting_web_input.match(letters))
				{
					var setting_web_input = "";
				}

				if(setting_web_input == '')
				{
					$('.setting_web_input').val('Please enter a valid nick name');
				}
				else
				{
					var query_to_send = "UPDATE users_info SET website = '" + setting_web_input + "' WHERE username = '" + username + "'";
					$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
					{
						if(e=='1')
						{
							location.reload();
						}
						else
						{
							alert('Something went wrong');
						}
					});
				}
			});
		
		});

	/*----for changing address------*/
		$('.setting_address_change_button').click(function()
		{
			$('.setting_address_change_button').fadeOut(0);
			$('.setting_address_old').fadeOut(0);
			$('.setting_address_input').fadeIn(0);
			$('.setting_address_done_button').fadeIn(0);

			var username = "<?php echo $username; ?>";

			$('.setting_address_done_button').click(function()
			{
				var setting_address_input =  $.trim($('.setting_address_input').val());

				var letters = /^[0-9a-zA-Z ]+$/;
				if(!setting_address_input.match(letters))
				{
					var setting_address_input = "";
				}

				if(setting_address_input == '')
				{
					$('.setting_address_input').val('Please enter a valid nick name');
				}
				else
				{
					var query_to_send = "UPDATE users_info SET address = '" + setting_address_input + "' WHERE username = '" + username + "'";
					$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
					{
						if(e=='1')
						{
							location.reload();
						}
						else
						{
							alert('Something went wrong');
						}
					});
				}
			});
		
		});

	/*-----for deleting bucket-------*/
		$('.setting_bucket_change_button').click(function()
		{
			var username = "<?php echo $username; ?>";
			var selected_bucket = $.trim($(this).parent().find('span').text());

			query_to_send = "DELETE FROM " + username + "_info WHERE bucket = '" + selected_bucket + "'";

			$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
			{
				if(e=='1')
				{
					location.reload();
				}
				else
				{
					alert('Something went wrong');
				}
			});

			//alert(query_to_send);
		});

	/*---for adding bucket------*/
		$('.setting_bucket_add_button').click(function()
		{
			$('.setting_bucket_add_button').fadeOut(0);
			$('.setting_bucket_input').fadeIn(0);
			$('.setting_bucket_done_button').fadeIn(0);

			var username = "<?php echo $username; ?>";

			$('.setting_bucket_done_button').click(function()
			{
				var setting_bucket_input =  $.trim($('.setting_bucket_input').val());

				var letters = /^[0-9a-zA-Z ]+$/;
				if(!setting_bucket_input.match(letters))
				{
					var setting_bucket_input = "";
				}

				if(setting_bucket_input == '')
				{
					$('.setting_bucket_input').val('Please enter a valid nick name');
				}
				else
				{
					var query_to_send = "INSERT INTO " + username + "_info VALUES('', '" + setting_bucket_input + "', '', '', '', '', '', '')";
					$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
					{
						if(e=='1')
						{
							location.reload();
						}
						else
						{
							alert('Something went wrong');
						}
					});
				}
			});
		});

	/*-----for deleting passion-------*/
		$('.setting_passion_change_button').click(function()
		{
			var username = "<?php echo $username; ?>";
			var selected_passion = $.trim($(this).parent().find('span').text());

			query_to_send = "DELETE FROM " + username + "_info WHERE passion = '" + selected_passion + "'";

			$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
			{
				if(e=='1')
				{
					location.reload();
				}
				else
				{
					alert('Something went wrong');
				}
			});

			//alert(query_to_send);
		});

	/*---for adding passion------*/
		$('.setting_passion_add_button').click(function()
		{
			$('.setting_passion_add_button').fadeOut(0);
			$('.setting_passion_input').fadeIn(0);
			$('.setting_passion_done_button').fadeIn(0);

			var username = "<?php echo $username; ?>";

			$('.setting_passion_done_button').click(function()
			{
				var setting_passion_input =  $.trim($('.setting_passion_input').val());

				var letters = /^[0-9a-zA-Z ]+$/;
				if(!setting_passion_input.match(letters))
				{
					var setting_passion_input = "";
				}


				if(setting_passion_input == '')
				{
					$('.setting_passion_input').val('Please enter a valid nick name');
				}
				else
				{
					var query_to_send = "INSERT INTO " + username + "_info VALUES('', '', '" + setting_passion_input + "', '', '', '', '', '')";
					$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
					{
						if(e=='1')
						{
							location.reload();
						}
						else
						{
							alert('Something went wrong');
						}
					});
				}
			});
		});

	/*-----for deleting trip-------*/
		$('.setting_trip_change_button').click(function()
		{
			var username = "<?php echo $username; ?>";
			var selected_trip = $.trim($(this).parent().find('span').text());

			query_to_send = "DELETE FROM " + username + "_info WHERE travel = '" + selected_trip + "'";

			//alert(query_to_send);

			$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
			{
				if(e=='1')
				{
					location.reload();
				}
				else
				{
					alert('Something went wrong');
				}
			});

			//alert(query_to_send);
		});

	/*---for adding trip------*/
		$('.setting_trip_add_button').click(function()
		{
			$('.setting_trip_add_button').fadeOut(0);
			$('.setting_trip_input').fadeIn(0);
			$('.setting_trip_done_button').fadeIn(0);

			var username = "<?php echo $username; ?>";

			$('.setting_trip_done_button').click(function()
			{
				var setting_trip_input =  $.trim($('.setting_trip_input').val());

				var letters = /^[0-9a-zA-Z ]+$/;
				if(!setting_trip_input.match(letters))
				{
					var setting_trip_input = "";
				}

				if(setting_trip_input == '')
				{
					$('.setting_trip_input').val('Please enter a valid nick name');
				}
				else
				{
					var query_to_send = "INSERT INTO " + username + "_info VALUES('', '', '', '" + setting_trip_input + "', '', '', '', '')";
					$.post('php/change_setting.php', {query_to_send: query_to_send}, function(e)
					{
						if(e=='1')
						{
							location.reload();
						}
						else
						{
							alert('Something went wrong');
						}
					});
				}
			});
		});

	</script>
</body>
</html>