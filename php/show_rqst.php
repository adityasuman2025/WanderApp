<?php
	include('connect_db.php');
	$signed_username = $_POST['signed_username'];

	if(isset($_COOKIE['signed_username']))
	{
		$signed_username = $_COOKIE['signed_username'];	

	//getting companion rqst of the signed user
		$show_rqst_query = "SELECT comp_rqst FROM " . $signed_username . "_info WHERE comp_rqst !='' ORDER BY id DESC";
		$show_rqst_query_run = mysqli_query($connect_link, $show_rqst_query);
		
		while($show_rqst_assoc = mysqli_fetch_assoc($show_rqst_query_run))
		{
			$show_rqst_username = $show_rqst_assoc['comp_rqst'];

		//getting basic details of the companion rqst sender
			$comp_rqst_user_query = "SELECT * FROM users_info WHERE username = '" . $show_rqst_username . "'";
			$comp_rqst_user_query_run = mysqli_query($connect_link, $comp_rqst_user_query);
			$comp_rqst_user_assoc = mysqli_fetch_assoc($comp_rqst_user_query_run); 

			$comp_rqst_name = $comp_rqst_user_assoc['name'];
			$comp_rqst_dp = $comp_rqst_user_assoc['dp'];
			$dp_location =  "img/". $show_rqst_username . "_photo/" . $comp_rqst_dp;
			$actual_link = "http://$_SERVER[HTTP_HOST]/user.php?username=$show_rqst_username";

			echo "	<div class=\"comp_rqst_user_div\">
						<img src=\"$dp_location\" onerror=\"this.onerror=null;this.src='img/def_user_dp.jpg';\"/>
						&nbsp 
						<a href=\"$actual_link\" target=\"_blank\">$comp_rqst_name</a>
						<div class=\"comp_rqst_user_buttons\">							
							<button text=\"$show_rqst_username\" class=\"accept_rqst_button\">Accept</button>
							<button text=\"$show_rqst_username\" class=\"delete_rqst_button\">Delete</button>
						</div>
					</div>";
		}
	}
	else
	{
		$signed_username = null;
	}
?>

<script type="text/javascript">
//on clicking on accept rqst buttoon
	$('.accept_rqst_button').click(function()
	{
		var username = $(this).attr('text');
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
							//adding this event in notification table
								var add_notification_query = "INSERT INTO user_notifications VALUES('', '" + username + "', 'companion', '', '" + signed_username + "', 'has accepted your companion request', now())";

								$.post('php/add_notification.php', {add_notification_query: add_notification_query}, function(data)
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

//on clicking on delete rqst buttoon
	$('.delete_rqst_button').click(function()
		{
			var username = $(this).attr('text');
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
</script>