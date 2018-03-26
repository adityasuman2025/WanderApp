<?php
	include('connect_db.php');
	$username = $_POST['username'];

	if(isset($_COOKIE['signed_username']))
	{
		$signed_username = $_COOKIE['signed_username'];
	}
	else
	{
		$signed_username = "";
	}
	
	$get_fvrt_post_id_query = "SELECT fvrt_post_id FROM " . $username . "_info WHERE fvrt_post_id !='' ORDER BY id DESC LIMIT 4"; 
	$get_fvrt_post_id_query_run = mysqli_query($connect_link, $get_fvrt_post_id_query);

	while($fvrt_post_id_assoc = mysqli_fetch_assoc($get_fvrt_post_id_query_run))
	{
		$fvrt_post_id = $fvrt_post_id_assoc['fvrt_post_id'];

	//getting that post from its post id
		$fvrt_post_query = "SELECT * FROM " . $username . "_post WHERE id = $fvrt_post_id";
		$fvrt_post_query_run = mysqli_query($connect_link, $fvrt_post_query);

		while($get_fvrt_post_assoc = mysqli_fetch_assoc($fvrt_post_query_run)) 
		{
			$get_post_id = $get_fvrt_post_assoc['id'];
			$get_post_text = $get_fvrt_post_assoc['text'];
			$get_post_photo = $get_fvrt_post_assoc['photo'];
			$get_post_video = $get_fvrt_post_assoc['video'];			
		}

		echo "<div class=\"fvrt_post_container\">";
			if($signed_username == $username)
			{
				echo "<button fvrt_post_id = \"$fvrt_post_id\" class=\"fvrt_remove_button\"><img src=\"img/delete1.png\"></button>";
			}
			
			echo "<div fvrt_post_id = \"$fvrt_post_id\" class=\"fvrt_post_div\">";
					
					if($get_post_photo !="")
					{
						echo "<center><img class=\"post_image_content\" src=\"img/" . $username . "_photo/" . $get_post_photo ." \" onerror=\"this.onerror=null;this.src='img/photo_placeholder.png';\" /></center>";
					}

					if($get_post_video !="")
					{
						echo "<center><video class=\"post_video_content\">
								  <source src=\"vid/".$username, "_video/". $get_post_video."#t=1\" type=\"video/mp4\">
								  Your browser does not support the video tag.
							</video></center>";
					}

					if($get_post_text !="")
					{
						echo "<div class=\"post_text_content\">$get_post_text</div>";					
					}

			echo "</div>";
		echo "</div>";
	}
?>

<script type="text/javascript">

	//on clicking on post //opening the post 
		$('.fvrt_post_div').click(function()
		{
			var username = $.trim("<?php echo $username; ?>");
			var this_post_id = $(this).attr('fvrt_post_id');
			
			window.location.href = "post_view.php?username=" + username + "&post_id=" + this_post_id;
		});

	//on clicking on remove favourite button
		$('.fvrt_remove_button').click(function()
		{
			var this_post_id = $(this).attr('fvrt_post_id');
			var username = $.trim("<?php echo $username; ?>");
			var signed_username = $.trim("<?php echo $signed_username; ?>");
			
			var remove_fvrt_query = "DELETE FROM " + signed_username + "_info WHERE fvrt_post_id = " + this_post_id ;

			$.post('php/change_setting.php', {query_to_send: remove_fvrt_query}, function()
			{
				location.reload();
			});
		});

</script>