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

	//checking the type of notification 
		echo "	<div class=\"accepted_rqst_div\">";
					if($notifi_type == "companion")
					{
						$actual_link = "http://$_SERVER[HTTP_HOST]/user.php?username=$show_notification_by";

					//showing notification 
					echo "	<a href=\"$actual_link\">
								<img src=\"img/notify_frnd2.png\">
								&nbsp
								$show_notification_by
								<span>$show_notification_text</span>
							</a>";
					}
					else if($notifi_type == "like" && $show_notification_by !="")
					{
					//getting information of that post
						$get_post_query = "SELECT * FROM " . $signed_username . "_post WHERE id = $show_notification_post_id";
						$get_post_query_run = mysqli_query($connect_link, $get_post_query);
						$get_post_assoc = mysqli_fetch_assoc($get_post_query_run);
						$get_post_photo = $get_post_assoc['photo'];

					//getting all the username associated with that notification
						$comma_count = substr_count($show_notification_by,",");
						$show_notification_by = rtrim($show_notification_by, ", ");

					//showing notification 
						echo "	<button class=\"accepted_rqst_button\" post_id=\"$show_notification_post_id\">";
									if($get_post_photo !='')
									{
										echo "<img src=\"img/" . $signed_username . "_photo/" . $get_post_photo ." \"/>";
									}
									else
									{
										echo "<img src=\"img/notify_like2.png\">";
									}
									
									if($comma_count == 1)
									{
									echo "	&nbsp
											<a>$show_notification_by</a> has liked your post";
									}
									else if($comma_count == 2)
									{
										$liked_one = explode(", ", $show_notification_by);

										echo "	&nbsp
												<a>$liked_one[0], $liked_one[1]</a> have liked your post";
									}
									else if($comma_count == 3)
									{
										$liked_one = explode(", ", $show_notification_by);

										echo "	&nbsp
												<a>$liked_one[0], $liked_one[1], $liked_one[2]</a> have liked your post";
									}
									else
									{
										$left_comma = $comma_count - 3; 
										
										$liked_one = explode(", ", $show_notification_by);

										echo "	&nbsp
												<a>$liked_one[0], $liked_one[1], $liked_one[2]</a> and $left_comma others have liked your post";
									}

						echo "		<span class=\"notification_time\">
										$time_in_mnths $time_in_days $time_in_hrs $time_in_mins ago
									</span>
								</button>";
					}
					else if($notifi_type == "comment" && $show_notification_by !="")
					{
					//getting information of that post
						$get_post_query = "SELECT * FROM " . $signed_username . "_post WHERE id = $show_notification_post_id";
						$get_post_query_run = mysqli_query($connect_link, $get_post_query);
						$get_post_assoc = mysqli_fetch_assoc($get_post_query_run);
						$get_post_photo = $get_post_assoc['photo'];

					//getting all the username associated with that notification
						$comma_count = substr_count($show_notification_by,",");
						$show_notification_by = rtrim($show_notification_by, ", ");

						//showing notification 
						echo "	<button class=\"accepted_rqst_button\" post_id=\"$show_notification_post_id\">";
									if($get_post_photo !='')
									{
										echo "<img src=\"img/" . $signed_username . "_photo/" . $get_post_photo ." \"/>";
									}
									else
									{
										echo "<img src=\"img/notify_comment2.png\">";
									}
									
									if($comma_count == 1)
									{
									echo "	&nbsp
											<a>$show_notification_by</a> has commented on your post";
									}
									else if($comma_count == 2)
									{
										$liked_one = explode(", ", $show_notification_by);

										echo "	&nbsp
												<a>$liked_one[0], $liked_one[1]</a> have commented on your post";
									}
									else if($comma_count == 3)
									{
										$liked_one = explode(", ", $show_notification_by);

										echo "	&nbsp
												<a>$liked_one[0], $liked_one[1], $liked_one[2]</a> have commented on your post";
									}
									else
									{
										$left_comma = $comma_count - 3; 
										
										$liked_one = explode(", ", $show_notification_by);

										echo "	&nbsp
												<a>$liked_one[0], $liked_one[1], $liked_one[2]</a> and $left_comma others have commented on your post";
									}

						echo "		<span class=\"notification_time\">
										$time_in_mnths $time_in_days $time_in_hrs $time_in_mins ago
									</span>
								</button>";
					}

		echo 	"</div>";
	}
?>

<!----script---------->
	<script type="text/javascript">
		$('.accepted_rqst_button').click(function()
		{
			var this_post_id = parseInt($(this).attr('post_id'));
			var signed_username = "<?php echo $signed_username; ?>";

			window.location.href = "post_view.php?username=" + signed_username + "&post_id=" + this_post_id;
		});
	</script>