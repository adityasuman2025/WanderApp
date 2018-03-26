<?php
	include('php/connect_db.php');
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery.js"></script>

	<meta name="viewport" content ="width= device-width, initial-scale= 1">
</head>
<body>

<!--------header bar-------->
	<div class="header_bar">
	<!----header title---->
		<div class="header_title_div">
			<img src="img/logo.png" class="header_logo"/>
			<span class="header_logo_text">
				<?php echo $location_array['time_zone']; ?>
			</span>
		</div>

	<!----header icon---->
		<div class="header_icon_div">								
			<?php
				if(isset($_COOKIE['signed_username']))
				{
					$signed_username = $_COOKIE['signed_username'];

					echo "
							<a href=\"home.php\"><img src=\"img/header/home.png\" class=\"header_home\"></a>
							<a href=\"user.php?username=" . $_COOKIE['signed_username'] . "\"><img src=\"img/header/profile.png\" class=\"header_profile\"></a>
							<img src=\"img/header/msg.png\" class=\"header_msg\">";

				//checking any new notification 
					$check_new_notification_query = "SELECT id FROM user_notifications WHERE view =  1 AND notifi_user = '$signed_username'";
					$check_new_notification_query_run = mysqli_query($connect_link, $check_new_notification_query);
					$check_new_notification_no = mysqli_num_rows($check_new_notification_query_run);

				//checking any new companion rqst
					$check_new_rqst_query = "SELECT id FROM " . $signed_username . "_info WHERE comp_rqst != ''";
					$check_new_rqst_query_run = mysqli_query($connect_link, $check_new_rqst_query);
					$check_new_rqst_no = mysqli_num_rows($check_new_rqst_query_run);

					$check_new_notification_no = $check_new_notification_no + $check_new_rqst_no;

					if($check_new_notification_no == 0)
					{
						echo "<img src=\"img/header/notify.png\" class=\"header_notify\">";
					}
					else
					{
						echo "<img src=\"img/header/notify_new.png\" class=\"header_notify\">";
					}

					echo "	<img src=\"img/header/setting.png\" class=\"header_setting\">";
				}
			?>
		</div>
	</div>
	
<!-------bottom header bar for mobile------>
	<div class="header_icon_mob_div">	
	<!----header icon for mobiles---->
		<?php
			if(isset($_COOKIE['signed_username']))
			{
				$signed_username = $_COOKIE['signed_username'];

					echo "	<a href=\"home.php\"><img src=\"img/header/home.png\" class=\"header_home\"></a>
							<a href=\"user.php?username=" . $_COOKIE['signed_username'] . "\"><img src=\"img/header/profile.png\" class=\"header_profile\"></a>
							<img src=\"img/header/msg.png\" class=\"header_msg\">";

				//checking any new notification 
					$check_new_notification_query = "SELECT id FROM user_notifications WHERE view =  1 AND notifi_user = '$signed_username'";
					$check_new_notification_query_run = mysqli_query($connect_link, $check_new_notification_query);
					$check_new_notification_no = mysqli_num_rows($check_new_notification_query_run);

				//checking any new companion rqst
					$check_new_rqst_query = "SELECT id FROM " . $signed_username . "_info WHERE comp_rqst != ''";
					$check_new_rqst_query_run = mysqli_query($connect_link, $check_new_rqst_query);
					$check_new_rqst_no = mysqli_num_rows($check_new_rqst_query_run);

					$check_new_notification_no = $check_new_notification_no + $check_new_rqst_no;
					
					if($check_new_notification_no == 0)
					{
						echo "<img src=\"img/header/notify.png\" class=\"header_notify\">";
					}
					else
					{
						echo "<img src=\"img/header/notify_new.png\" class=\"header_notify\">";
					}

					echo "	<img src=\"img/header/setting.png\" class=\"header_setting\">";

					echo "	<img src=\"img/header/chat.png\" mob_chat_switch=\"on\" class=\"header_chat\">
					";
			}
			else
			{
				echo "<a class=\"header_login_button\" href=\"index.php\">Login / Register</a>";
			}

		?>
	</div>

<!------sub menu of setting icon------>
	<ul class="setting_sub">
		<li><a href="setting.php">Settings</a></li>
		<li>Privacy</li>
		<li class="user_log_out">Log Out</li>
	</ul>

	<div class="setting_bckgrnd"></div>

<!-------ajax loading divs-------->
	<div class="ajax_loading_bckgrnd">
	</div>

	<div class="ajax_loading_div">
		<img class="close_icon" src="img/close.png"/>
		<div class="ajax_content"></div>
	</div>

<!-------post ajax loading divs-------->
	<div class="post_ajax_loading_div">
		<img class="close_icon" src="img/close.png"/>
		<div class="post_ajax_content"></div>
	</div>

<!-------notification ajax loading divs-------->
	<div class="notif_ajax_loading_div">
		<img class="close_icon" src="img/close.png"/>
		<div class="notif_ajax_content"></div>
	</div>

<!----------warning ajax box---------->
	<div class="warn_box">
			
	</div>

<!--------chat box---------->
	<?php
		if(isset($_COOKIE['signed_username']))
		{
			echo "<button class=\"chat_box_button\">Chat</button>";
			echo "	
					<div class=\"chat_box_div\">
						<div class=\"chat_box_title\">
							Online Companion
							<img src=\"img/minimise.png\">
						</div>

						<div class=\"search_chat\">
							<input type=\"text\">
							<button><img src=\"img/search.png\"></button>
						</div>
					</div>
				";
		}
	?>

<!--script-------->
	<script type="text/javascript">

	//on closing the window
		$(window).on("beforeunload", function(e)
		{
			e.preventDefault();
			$(window).off('beforeunload'); 
			$.post('php/close_window.php', {}, function(e)
			{
				console.log(e);
			})

		});

	//chat box appearance and dispear
		$('.chat_box_button').click(function()
		{
			$(this).fadeOut(0);
			$('.chat_box_div').fadeIn(300);
		});

		$('.chat_box_title img').click(function()
		{
			$('.chat_box_button').fadeIn(300);
			$('.chat_box_div').fadeOut(0);
		});

	//chat box appearance and dispear on mob
		$('.header_chat').click(function()
		{
			$('.chat_box_title img').fadeOut(0);
				
			var mob_chat_switch = $(this).attr('mob_chat_switch');
			
			if(mob_chat_switch == 'on')
			{
				$('.chat_box_div').fadeIn(100);
				$(this).attr('mob_chat_switch', 'off');
			}
			else if(mob_chat_switch == 'off')
			{
				$('.chat_box_div').fadeOut(0);
				$(this).attr('mob_chat_switch', 'on');
			}
			
		});

	//on scrolling 
		$(window).scroll(function()
		{
			win_pos = $(window).scrollTop();
			//alert(win_pos);

			if(win_pos > 0)
			{
				$('.header_bar').css('background', '#00cc44');
			}
			else
			{
				$('.header_bar').css('background', 'rgba(0,0,0,0.0)');
			}
		});

	/*-----on clicking on notification button------*/
		$('.header_notify').click(function()
		{
			$('.ajax_loading_bckgrnd').fadeIn(500);
			$('.notif_ajax_loading_div').fadeIn(500);

			$('.ajax_loading_div').fadeOut(0);
			$('.post_ajax_loading_div').fadeOut(0);

			$.post('php/user_notification.php', {}, function(e)
			{
				$('.notif_ajax_content').html(e);
			});
		});

	/*-------on clicking on setting---*/
		$('.header_setting').click(function()
		{
			$('.setting_sub').fadeIn(100);
			$('.setting_bckgrnd').fadeIn(100);
		});

		$('.setting_bckgrnd').click(function()
		{
			$('.setting_sub').fadeOut(100);
			$('.setting_bckgrnd').fadeOut(100);
		});

	/*-----on clicking on log out-------*/
		$('.user_log_out').click(function()
		{
			$.post('php/logout_user.php', {}, function(data)
			{
				if(data==1)
				{
					$(location).attr('href', 'index.php');
				}
				else
				{
					//$('#logout_feed').text('Something went wrong while logging out');
				}
			});

		})

	/*-----for ajax loading divs------*/
		$('.ajax_loading_bckgrnd').click(function()
		{
			$('.ajax_loading_bckgrnd').fadeOut(500);
			$('.ajax_loading_div').fadeOut(500);

			$('.post_ajax_loading_div').fadeOut(500);
			$('.notif_ajax_loading_div').fadeOut(500);
		});

		$('.close_icon').click(function()
		{
			$('.ajax_loading_bckgrnd').fadeOut(500);
			$('.ajax_loading_div').fadeOut(500);

			$('.post_ajax_loading_div').fadeOut(500);
			$('.notif_ajax_loading_div').fadeOut(500);
		});

	</script>
</body>
</html>