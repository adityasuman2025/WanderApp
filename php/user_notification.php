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
?>

<div class="notification_button">
	<div class="notify_like_button">
		<?php
		//checking any new like notification 
			$check_new_notification_query = "SELECT id FROM user_notifications WHERE view =  1 AND notifi_user = '$signed_username' AND notifi_type='like'";
			$check_new_notification_query_run = mysqli_query($connect_link, $check_new_notification_query);
			$check_new_notification_no = mysqli_num_rows($check_new_notification_query_run);

			if($check_new_notification_no == 0)
			{
				echo "<img src=\"img/notify_like.png\">";
			}
			else
			{
				echo "<img src=\"img/notify_like_new.png\">";
			}
		?>
	</div>
	
	<div class="notify_comment_button">
		<?php
		//checking any new comment notification 
			$check_new_notification_query = "SELECT id FROM user_notifications WHERE view =  1 AND notifi_user = '$signed_username' AND notifi_type='comment'";
			$check_new_notification_query_run = mysqli_query($connect_link, $check_new_notification_query);
			$check_new_notification_no = mysqli_num_rows($check_new_notification_query_run);

			if($check_new_notification_no == 0)
			{
				echo "<img src=\"img/notify_comment.png\">";
			}
			else
			{
				echo "<img src=\"img/notify_comment_new.png\">";
			}
		?>
	</div>

	<div class="notify_rqst_button">
		<?php
		//checking any new companion rqst
			$check_new_notification_query = "SELECT id FROM " . $signed_username . "_info WHERE comp_rqst != ''";
			$check_new_notification_query_run = mysqli_query($connect_link, $check_new_notification_query);
			$check_new_notification_no = mysqli_num_rows($check_new_notification_query_run);

			if($check_new_notification_no == 0)
			{
				echo "<img src=\"img/notify_rqst.png\">";
			}
			else
			{
				echo "<img src=\"img/notify_rqst_new.png\">";
			}
		?>
	</div>

	<div class="notify_comp_button">
		<?php
		//checking any new companion notification 
			$check_new_notification_query = "SELECT id FROM user_notifications WHERE view =  1 AND notifi_user = '$signed_username' AND notifi_type='companion'";
			$check_new_notification_query_run = mysqli_query($connect_link, $check_new_notification_query);
			$check_new_notification_no = mysqli_num_rows($check_new_notification_query_run);

			if($check_new_notification_no == 0)
			{
				echo "<img src=\"img/notify_frnd.png\">";
			}
			else
			{
				echo "<img src=\"img/notify_frnd_new.png\">";
			}
		?>
	</div>
</div>
<br>

<div class="notification_content"></div>

<!-----scripts-------->
<script type="text/javascript">

//default showing like notification
	$('.notify_like_button').css('background', '#00cc44');

	var signed_username = "<?php echo $signed_username; ?>";
	var notifi_type = "like";
	var show_notification_query = "SELECT * FROM user_notifications WHERE notifi_user = '" + signed_username  + "' AND notifi_type = 'like' ORDER BY id DESC LIMIT 50";

	$.post('php/show_notification.php', {show_notification_query: show_notification_query, notifi_type: notifi_type}, function(data)
	{
		$('.notification_content').html(data);

	//hiding the highlight of the notification when the notification is viewed
		var remove_highlight_query = "UPDATE user_notifications SET view = '0' WHERE notifi_type = 'like' AND view = '1' AND notifi_user = '" + signed_username + "'";

		$.post('php/add_notification.php', {add_notification_query: remove_highlight_query}, function(e)
		{
			
		});
	});

//on clicking on notify rqst button
	$('.notify_rqst_button').click(function()
	{
		var signed_username = "<?php echo $signed_username; ?>";
		$.post('php/show_rqst.php', {signed_username: signed_username}, function(e)
		{
			$('.notification_content').html(e);
		});

		$(this).css('background', '#00cc44');
		$(this).parent().find('div').not(this).css('background', 'grey');
	});

//on clicking on notify comment button
	$('.notify_comment_button').click(function()
	{
		$(this).css('background', '#00cc44');
		$(this).parent().find('div').not(this).css('background', 'grey');

		var signed_username = "<?php echo $signed_username; ?>";
		var notifi_type = "comment";
		var show_notification_query = "SELECT * FROM user_notifications WHERE notifi_user = '" + signed_username  + "' AND notifi_type = 'comment' ORDER BY id DESC LIMIT 50";

		$.post('php/show_notification.php', {show_notification_query: show_notification_query, notifi_type: notifi_type}, function(data)
		{
			$('.notification_content').html(data);

		//hiding the highlight of the notification when the notification is viewed
			var remove_highlight_query = "UPDATE user_notifications SET view = '0' WHERE notifi_type = 'comment' AND view = '1' AND notifi_user = '" + signed_username + "'";

			$.post('php/add_notification.php', {add_notification_query: remove_highlight_query}, function(e)
			{

			});
		});
	});

//on clicking on notify like button
	$('.notify_like_button').click(function()
	{
		$(this).css('background', '#00cc44');
		$(this).parent().find('div').not(this).css('background', 'grey');

		var signed_username = "<?php echo $signed_username; ?>";
		var notifi_type = "like";
		var show_notification_query = "SELECT * FROM user_notifications WHERE notifi_user = '" + signed_username  + "' AND notifi_type = 'like' ORDER BY id DESC LIMIT 50";

		$.post('php/show_notification.php', {show_notification_query: show_notification_query, notifi_type: notifi_type}, function(data)
		{
			$('.notification_content').html(data);

		//hiding the highlight of the notification when the notification is viewed
			var remove_highlight_query = "UPDATE user_notifications SET view = '0' WHERE notifi_type = 'like' AND view = '1' AND notifi_user = '" + signed_username + "'";

			$.post('php/add_notification.php', {add_notification_query: remove_highlight_query}, function(e)
			{

			});
		});
	});

//on clicking on notify companion button
	$('.notify_comp_button').click(function()
	{
		$(this).css('background', '#00cc44');
		$(this).parent().find('div').not(this).css('background', 'grey');

		var signed_username = "<?php echo $signed_username; ?>";
		var notifi_type = "companion";
		var show_notification_query = "SELECT * FROM user_notifications WHERE notifi_user = '" + signed_username  + "' AND notifi_type = 'companion' ORDER BY id DESC LIMIT 50";

		$.post('php/show_notification.php', {show_notification_query: show_notification_query, notifi_type: notifi_type}, function(data)
		{
			$('.notification_content').html(data);

		//hiding the highlight of the notification when the notification is viewed
			var remove_highlight_query = "UPDATE user_notifications SET view = '0' WHERE notifi_type = 'companion' AND view = '1' AND notifi_user = '" + signed_username + "'";

			$.post('php/add_notification.php', {add_notification_query: remove_highlight_query}, function(e)
			{

			});
		});
	});

</script>