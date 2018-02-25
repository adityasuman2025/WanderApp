<?php
	include('connect_db.php');

	$username = $_POST['username'];
	
//fetching table from users data
	$fetch_user_about_query = "SELECT * FROM users_info WHERE username = '" . $username . "'";
	$fetch_user_about_query_run = mysqli_query($connect_link, $fetch_user_about_query);
	$fetch_user_about_assoc = mysqli_fetch_assoc($fetch_user_about_query_run);

	$about_user_name = $fetch_user_about_assoc['name'];
	$about_user_username = $fetch_user_about_assoc['username'];
	$about_user_dp = $fetch_user_about_assoc['dp'];
	$about_user_cover = $fetch_user_about_assoc['cover'];
	$about_user_sex = $fetch_user_about_assoc['sex'];
	$about_user_dob = $fetch_user_about_assoc['dob'];
	$about_user_address = $fetch_user_about_assoc['address'];
	$about_user_language = $fetch_user_about_assoc['language'];
	$about_user_website = $fetch_user_about_assoc['website'];
	$about_user_about = $fetch_user_about_assoc['about'];
	$about_user_nick_name = $fetch_user_about_assoc['nick_name'];
	

//fetching data from other tables of that user
	$fetch_user_bucket_query = "SELECT bucket FROM " . $username . "_info WHERE bucket !=''";
	$fetch_user_passion_query = "SELECT passion FROM " . $username . "_info WHERE passion !=''";
	$fetch_user_travel_query = "SELECT travel FROM " . $username . "_info WHERE travel !=''";


?>

<!------user about page-------->
	<div class="user_about_div">
		<div class="row user_about">

		<!------about tab and dp-------->
			<div class="col-xs-12 col-md-3 user_dp_tab_div">
				<div class="user_dp">
					<?php
						$dp_location =  "img/". $username . "_photo/" . $about_user_dp;
						echo "<img src=\"$dp_location\" onerror=\"this.onerror=null;this.src='img/def_user_dp.jpg';\"/>";
					?>
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
				<div class="user_about_button_div">
					<h3>Basic Intro</h3>
					<div class="about_user_basic">

						<span class="about_title">Name </span> <?php echo $about_user_name; ?>
						<br><br>

						<span class="about_title">Username </span> <?php echo $about_user_username; ?>
						<br><br>

						<?php
							if($about_user_nick_name != '')
							{
								echo "<span class=\"about_title\">Nick Name </span> $about_user_nick_name<br><br>";
							}
						?>
						
						<span class="about_title">Account </span> 
						<?php
							$actual_link = "http://$_SERVER[HTTP_HOST]/user.php?username=$username";
							echo "<a href=\"$actual_link\" target=\"_blank\">$actual_link</a>"; 
						?>
						<br><br>

						<?php
							if($about_user_sex != '')
							{
								echo "<span class=\"about_title\">Sex </span> $about_user_sex<br><br>";
							}
						?>
						
						<?php
							if($about_user_dob != '')
							{
								$about_user_dob = date('d M Y', strtotime($about_user_dob));
								echo "<span class=\"about_title\">Date Of Birth </span> $about_user_dob<br><br>";
							}
						?>

						<?php
							if($about_user_language != '')
							{
								echo "<span class=\"about_title\">Language </span> $about_user_language<br><br>";
							}
						?>

						<?php
							if($about_user_website != '')
							{
								echo "<span class=\"about_title\">Website </span> <a target=\"_blank\" href=\"http://$about_user_website\">$about_user_website</a><br><br>";
							}
						?>

						<?php
							if($about_user_address != '')
							{
								echo "<span class=\"about_title\">Address </span> $about_user_address<br><br>";
							}
						?>
					</div>

						<?php
							if($about_user_about != '')
							{
								echo "<h3>About</h3>
										<span class=\"about_user_about\">$about_user_about</span>
										<br><br>";
							}
						?>


				</div>
				
			<!-----general button div---->
				<div class="user_general_button_div">

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
												echo "<li><img src=\"img/bucket.png\"> $user_bucket</li>";
											}
										}
									}
									
								}
							?>
						</ul>
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
												echo "<li><img src=\"img/passion1.png\"> $user_passion</li>";
											}
											
										}
									}
								}
							?>
							
						</ul>					
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
												echo "<li><img src=\"img/trip.png\"> $user_travel</li>";
											}
										}
									}
								}
							?>
							
						</ul>
					</div>

				</div>
			</div>
		</div>
	</div>

<!-----script-------->
	<script type="text/javascript">

	//for switching between tabs
		$('.user_about_button_div').fadeIn(0);
		$('.user_about_about_button').css('background', '#00cc44');

		$('.user_about_about_button').click(function()
		{
			$('.user_about_button_div').fadeIn(500);
			$('.user_general_button_div').fadeOut(0);

			$(this).css('background', '#00cc44');
			$('.user_about_general_button').css('background', 'grey');
		});

		$('.user_about_general_button').click(function()
		{
			$('.user_general_button_div').fadeIn(500);
			$('.user_about_button_div').fadeOut(0);

			$(this).css('background', '#00cc44');
			$('.user_about_about_button').css('background', 'grey');
		});

	</script>