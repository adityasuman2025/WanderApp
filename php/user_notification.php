<?php
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
	<div class="notify_like_button"><img src="img/notify_like.png"/></div>
	<div class="notify_comment_button"><img src="img/notify_comment.png"/></div>
	<div class="notify_rqst_button"><img src="img/notify_rqst.png"/></div>
	<div class="notify_comp_button"><img src="img/notify_frnd.png"/></div>
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
		});
	});

//on clicking on like rqst button
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
		});
	});

</script>