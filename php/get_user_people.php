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

	$get_user_people_query = $_POST['get_user_people_query'];
	$user_what_people = $_POST['user_what_people'];

	if($get_user_people_query_run = mysqli_query($connect_link, $get_user_people_query))
	{
		while($get_user_people_assoc = mysqli_fetch_assoc($get_user_people_query_run))
		{
			$people_username = $get_user_people_assoc[$user_what_people];

		//fetching table from users data
			$fetch_user_about_query = "SELECT * FROM users_info WHERE username = '" . $people_username . "'";
			$fetch_user_about_query_run = mysqli_query($connect_link, $fetch_user_about_query);
			$fetch_user_about_assoc = mysqli_fetch_assoc($fetch_user_about_query_run);

			$about_user_name = $fetch_user_about_assoc['name'];
			$about_user_username = $fetch_user_about_assoc['username'];
			$about_user_dp = $fetch_user_about_assoc['dp'];

			$dp_location =  "img/". $people_username . "_photo/" . $about_user_dp;
			$actual_link = "http://$_SERVER[HTTP_HOST]/user.php?username=$people_username";
						
			echo "	<a href=\"$actual_link\" class=\"user_people_div\">
						<img src=\"$dp_location\" onerror=\"this.onerror=null;this.src='img/def_user_dp.jpg';\"/>
						&nbsp
						<span>$about_user_name</span>
						&nbsp";

						if($user_what_people == "block")
						{
							echo "<img blocked_username= \"$people_username\" class= \"remove_people_block_button\" src=\"img/remove.png\">";
						}

			echo "	</a>";

		}
	}
?>

<script type="text/javascript">
//on clicking on remove block button
	$('.remove_people_block_button').click(function()
	{
		var blocked_username = $(this).attr('blocked_username');
		var signed_username = "<?php echo $signed_username; ?>";

		var remove_people_block_query = "DELETE FROM " + signed_username + "_info WHERE block = '" + blocked_username + "' LIMIT 1";

		$.post('php/change_setting.php', {query_to_send: remove_people_block_query}, function(a)
		{
			if(a == 1)
			{
				$('.user_comp_button_div').fadeIn(500);
				$('.user_block_button_div').fadeOut(0);
			}
		});
	});
</script>