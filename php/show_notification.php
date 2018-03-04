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
	
	$show_notification_query = $_POST['show_notification_query'];
	$notifi_type = $_POST['notifi_type'];

	$show_notification_query_run = mysqli_query($connect_link, $show_notification_query);
	while($show_notification_assoc = mysqli_fetch_assoc($show_notification_query_run))
	{
		$show_notification_by = $show_notification_assoc['notifi_by'];
		$show_notification_text = $show_notification_assoc['notifi_text'];
		$show_notification_post_id = $show_notification_assoc['post_id'];
		$show_notification_time = $show_notification_assoc['time'];

		//for getting time passed since post
			$content_timestamps = strtotime($show_notification_time);
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


	//getting basic details of the notification by user
		$comp_rqst_user_query = "SELECT * FROM users_info WHERE username = '" . $show_notification_by . "'";
		$comp_rqst_user_query_run = mysqli_query($connect_link, $comp_rqst_user_query);
		$comp_rqst_user_assoc = mysqli_fetch_assoc($comp_rqst_user_query_run); 

		$comp_rqst_name = $comp_rqst_user_assoc['name'];
		$actual_link = "http://$_SERVER[HTTP_HOST]/user.php?username=$show_notification_by";

		echo "	<div class=\"accepted_rqst_div\">";
				if($notifi_type == "companion")
				{
					echo "	<img src=\"img/notify_frnd2.png\">
							&nbsp
							<a target=\"_blank\" href=\"$actual_link\">$comp_rqst_name</a> $show_notification_text";
				}
				else if($notifi_type == "like")
				{
					$get_post_query = "SELECT * FROM " . $signed_username . "_post WHERE id = $show_notification_post_id";
					$get_post_query_run = mysqli_query($connect_link, $get_post_query);
					$get_post_assoc = mysqli_fetch_assoc($get_post_query_run);
					$get_post_photo = $get_post_assoc['photo'];

					echo "	<button class=\"accepted_rqst_button\" post_id=\"$show_notification_post_id\">";
								if($get_post_photo !='')
								{
									echo "<img src=\"img/" . $signed_username . "_photo/" . $get_post_photo ." \"/>";
								}
								else
								{
									echo "<img src=\"img/notify_like2.png\">";
								}
								
					echo "		&nbsp
								<a target=\"_blank\" href=\"$actual_link\">$comp_rqst_name</a> $show_notification_text
							</button>";
				}
				else if($notifi_type == "comment")
				{
					$get_post_query = "SELECT * FROM " . $signed_username . "_post WHERE id = $show_notification_post_id";
					$get_post_query_run = mysqli_query($connect_link, $get_post_query);
					$get_post_assoc = mysqli_fetch_assoc($get_post_query_run);
					$get_post_photo = $get_post_assoc['photo'];
					
					echo "	<button class=\"accepted_rqst_button\" post_id=\"$show_notification_post_id\">";
								if($get_post_photo !='')
								{
									echo "<img src=\"img/" . $signed_username . "_photo/" . $get_post_photo ." \"/>";
								}
								else
								{
									echo "<img src=\"img/notify_comment2.png\">";
								}
								
					echo "		&nbsp
								<a target=\"_blank\" href=\"$actual_link\">$comp_rqst_name</a> $show_notification_text
							</button>";
				}

			echo "	<div class=\"notification_time\">
						$time_in_mnths $time_in_days $time_in_hrs $time_in_mins ago
					</div>";
		echo 	"</div>";
	}
?>

<!----script---------->
	<script type="text/javascript">
		$('.accepted_rqst_button').click(function()
		{
			// $('.ajax_loading_bckgrnd').fadeIn(500);
			// $('.post_ajax_loading_div').fadeIn(500);

			// $('.ajax_loading_div').fadeOut(500);
			// $('.notif_ajax_loading_div').fadeOut(500);

			// var get_unique_post_query = "SELECT * FROM " + signed_username + "_post WHERE id = " + post_id;
			// $.post('php/get_unique_post.php', {get_unique_post_query: get_unique_post_query}, function(e)
			// {
			// 	$('.post_ajax_content').html(e);
			// });

			var this_post_id = parseInt($(this).attr('post_id'));
			var signed_username = "<?php echo $signed_username; ?>";

			window.location.href = "post_view.php?username=" + signed_username + "&post_id=" + this_post_id;
		});
	</script>