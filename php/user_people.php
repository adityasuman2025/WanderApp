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

	$username = $_POST['username'];
	
//fetching table from users data
	$fetch_user_about_query = "SELECT * FROM users_info WHERE username = '" . $username . "'";
	$fetch_user_about_query_run = mysqli_query($connect_link, $fetch_user_about_query);
	$fetch_user_about_assoc = mysqli_fetch_assoc($fetch_user_about_query_run);

	$about_user_name = $fetch_user_about_assoc['name'];
	$about_user_username = $fetch_user_about_assoc['username'];
	$about_user_dp = $fetch_user_about_assoc['dp'];
	$about_user_cover = $fetch_user_about_assoc['cover'];

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
						<li class="user_people_comp_button">Companion</li>
						<?php
							if($username == $signed_username)
							{
								echo "<li class=\"user_people_block_button\">Blocked</li>";
							}
						?>
					</ul>
				</div>
			</div>

		<!------selected tab display-------->
			<div class="col-xs-12 col-md-9 user_about_selected_tab">
				<div class="user_comp_button_div">
					<h3>Companions</h3>
					<div class="user_comp_content"></div>
					<br>
					<div class="user_comp_more">view more</div>
				</div>

				<div class="user_block_button_div">
					<h3>Blocked People</h3>
					<div class="user_block_content"></div>
					<br>
					<div class="user_block_more">view more</div>
				</div>
			</div>
		</div>
	</div>

<!-----script-------->
	<script type="text/javascript">

	//for getting total no of user companions
		var username = $.trim("<?php echo $username; ?>");
		var query_to_send = "SELECT id FROM " + username + "_info WHERE comp != ''";

		start = 0;
		limit = 5;
		org_limit = 5;

		$.post('php/get_user_post_count.php', {query_to_send: query_to_send}, function(data)
		{
			user_comp_count = data;
		});

	/*----for generatng load more for user companions---*/
		var get_user_people_query = "SELECT comp FROM " + username + "_info WHERE comp !='' ORDER BY id DESC LIMIT " + start + ", " + limit;
		var user_what_people = "comp";

		$.post('php/get_user_people.php', {get_user_people_query: get_user_people_query, user_what_people: user_what_people}, function(e)
		{
			$('.user_comp_content').html(e);

		//if initially total no of div is less than limit then load more is not visible
			if(user_comp_count <= limit)
			{
				$('.user_comp_more').fadeOut(0);
			}
			else
			{
				$('.user_comp_more').fadeIn(0);
			}
		});
			
	/*-------on clicking on load more of user companions-----------*/
		$('.user_comp_more').click(function()
		{
			limit = limit + org_limit;

			var get_user_people_query = "SELECT comp FROM " + username + "_info WHERE comp !='' ORDER BY id DESC LIMIT " + start + ", " + limit;
			var user_what_people = "comp";

			$.post('php/get_user_people.php', {get_user_people_query: get_user_people_query, user_what_people: user_what_people}, function(e)
			{
				$('.user_comp_content').html(e);

				user_comp_content_no = $('.user_comp_content .user_people_div').length;

				if(user_comp_content_no >= user_comp_count)
				{
					$('.user_comp_more').fadeOut(0);
				}
			});

			if(user_comp_content_no >= user_comp_count)
			{
				$('.user_comp_more').fadeOut(0);
			}

		});
			
	//for switching between tabs
		$('.user_comp_button_div').fadeIn(0);
		$('.user_people_comp_button').css('background', '#00cc44');

		$('.user_people_comp_button').click(function()
		{
			$('.user_comp_button_div').fadeIn(500);
			$('.user_block_button_div').fadeOut(0);

			$(this).css('background', '#00cc44');
			$('.user_people_block_button').css('background', 'grey');

		//for getting total no of user companions
			var username = $.trim("<?php echo $username; ?>");
			var query_to_send = "SELECT id FROM " + username + "_info WHERE comp != ''";

			start = 0;
			limit = 5;
			org_limit = 5;

			$.post('php/get_user_post_count.php', {query_to_send: query_to_send}, function(data)
			{
				user_comp_count = data;
			});

		/*----for generatng load more for user companions---*/
			var get_user_people_query = "SELECT comp FROM " + username + "_info WHERE comp !='' ORDER BY id DESC LIMIT " + start + ", " + limit;
			var user_what_people = "comp";

			$.post('php/get_user_people.php', {get_user_people_query: get_user_people_query, user_what_people: user_what_people}, function(e)
			{
				$('.user_comp_content').html(e);

			//if initially total no of div is less than limit then load more is not visible
				if(user_comp_count <= limit)
				{
					$('.user_comp_more').fadeOut(0);
				}
				else
				{
					$('.user_comp_more').fadeIn(0);
				}
			});
				
		/*-------on clicking on load more of user companions-----------*/
			$('.user_comp_more').click(function()
			{
				limit = limit + org_limit;

				var get_user_people_query = "SELECT comp FROM " + username + "_info WHERE comp !='' ORDER BY id DESC LIMIT " + start + ", " + limit;
				var user_what_people = "comp";

				$.post('php/get_user_people.php', {get_user_people_query: get_user_people_query, user_what_people: user_what_people}, function(e)
				{
					$('.user_comp_content').html(e);

					user_comp_content_no = $('.user_comp_content .user_people_div').length;

					if(user_comp_content_no >= user_comp_count)
					{
						$('.user_comp_more').fadeOut(0);
					}
				});

				if(user_comp_content_no >= user_comp_count)
				{
					$('.user_comp_more').fadeOut(0);
				}

			});

		});

		$('.user_people_block_button').click(function()
		{
			$('.user_block_button_div').fadeIn(500);
			$('.user_comp_button_div').fadeOut(0);

			$(this).css('background', '#00cc44');
			$('.user_people_comp_button').css('background', 'grey');

		//for getting total no of user blocked people
			var username = $.trim("<?php echo $username; ?>");
			var query_to_send = "SELECT id FROM " + username + "_info WHERE block != ''";

			start_block = 0;
			limit_block = 5;
			org_limit_block = 5;

			$.post('php/get_user_post_count.php', {query_to_send: query_to_send}, function(data)
			{
				user_block_count = data;
			});

		/*----for generatng load more for user blocked ones---*/
			var get_user_people_query = "SELECT block FROM " + username + "_info WHERE block !='' ORDER BY id DESC LIMIT " + start_block + ", " + limit_block;
			var user_what_people = "block";

			$.post('php/get_user_people.php', {get_user_people_query: get_user_people_query, user_what_people: user_what_people}, function(e)
			{
				$('.user_block_content').html(e);

			//if initially total no of div is less than limit then load more is not visible
				if(user_block_count <= limit_block)
				{
					$('.user_block_more').fadeOut(0);
				}
				else
				{
					$('.user_block_more').fadeIn(0);
				}
			});
				
		/*-------on clicking on load more of user blocked people -----------*/
			$('.user_block_more').click(function()
			{
				limit_block = limit_block + org_limit_block;

				var get_user_people_query = "SELECT block FROM " + username + "_info WHERE block !='' ORDER BY id DESC LIMIT " + start_block + ", " + limit_block;
				var user_what_people = "block";

				$.post('php/get_user_people.php', {get_user_people_query: get_user_people_query, user_what_people: user_what_people}, function(e)
				{
					$('.user_block_content').html(e);

					user_block_content_no = $('.user_block_content .user_people_div').length;

					if(user_block_content_no >= user_block_count)
					{
						$('.user_block_more').fadeOut(0);
					}
				});

				if(user_block_content_no >= user_block_count)
				{
					$('.user_block_more').fadeOut(0);
				}

			});

		});
	
	</script>