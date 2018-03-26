<?php
	include('connect_db.php');

	$this_post_id = $_POST['this_post_id'];
	$username = $_POST['username'];

	if(isset($_COOKIE['signed_username']))
	{
		$signed_username = $_COOKIE['signed_username'];

	//fetching user_info
		$fetch_user_name_query = "SELECT * FROM users_info WHERE username = '" . $signed_username . "'";
		$fetch_user_name_query_run = mysqli_query($connect_link, $fetch_user_name_query);

		$fetched_user_name = mysqli_num_rows($fetch_user_name_query_run);
		$fetched_user_name_name = mysqli_fetch_assoc($fetch_user_name_query_run);
		$signed_user_name = $fetched_user_name_name['name'];
	
		echo "	<div class=\"add_comment_div\">
					<div>
						<img src=\"img/comment.png\"/> 
						$signed_user_name
					</div>
					<textarea></textarea>
					<br>
					<button>Comment</button>
				</div>";
	}
	

	$post_user = $username;
	$post_id = $username . "_post_" . $this_post_id;
	$get_post_comment_query = "SELECT * FROM comments WHERE post_id = '" . $post_id . "' ORDER BY id DESC";

	if($get_post_comment_query_run = mysqli_query($connect_link, $get_post_comment_query))
	{
		while($get_post_comment_assoc = mysqli_fetch_assoc($get_post_comment_query_run))
		{
			$get_post_comment_username = $get_post_comment_assoc['user_name'];
			$get_post_comment_comment = $get_post_comment_assoc['comment'];
			$get_post_comment_time = $get_post_comment_assoc['time'];

		//for getting time passed since post
			$content_timestamps = strtotime($get_post_comment_time);
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

			$fetch_user_info_query = "SELECT name FROM users_info WHERE username = '" . $get_post_comment_username . "'";
			$fetch_user_info_query_run = mysqli_query($connect_link, $fetch_user_info_query);

			$fetched_users = mysqli_num_rows($fetch_user_info_query_run);

			if($fetched_users > 0)
			{
				$fetch_user_info_assoc = mysqli_fetch_assoc($fetch_user_info_query_run);
				$user_name = $fetch_user_info_assoc['name'];
				$actual_link = "http://$_SERVER[HTTP_HOST]/user.php?username=$get_post_comment_username";
							
				echo "	<div class=\"post_comment_user_div\"> 
							<img src=\"img/comment.png\"/> 
							<a href=\"$actual_link\">$user_name</a>

							&nbsp &nbsp
							<span class=\"post_comment_time\">
								$time_in_mnths $time_in_days $time_in_hrs $time_in_mins ago
							</span>
							
							<br>
							<div class=\"post_comment_user_comment\">
								$get_post_comment_comment
							</div>
						</div>";
				
			}
		}
	}
	else
	{
		echo 'Something went wrong while fetching comments.';
	}
?>

<script type="text/javascript">
	$('.add_comment_div button').click(function()
	{
		var this_post = $(this).parent().parent().parent().parent();
		var add_comment_text = $.trim($('.add_comment_div textarea').val());
		var signed_username = $.trim("<?php echo $signed_username; ?>");

		var post_id = $.trim("<?php echo $post_id; ?>");
		var this_post_id = $.trim("<?php echo $this_post_id; ?>");
		var post_user = $.trim("<?php echo $post_user; ?>");

		if(add_comment_text !="")
		{
			$.post('php/add_post_comment.php', {this_post_id: this_post_id, post_user: post_user, post_id: post_id, signed_username: signed_username, add_comment_text: add_comment_text}, function(e)
			{
				if(e == 1)
				{
					this_post.find('.post_comment_container').fadeOut(0);
				}
				else
				{
					alert('Something went wrong.');
				}
			});
		}
	});

</script>