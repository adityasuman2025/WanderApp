<div class="user_photo_div">

<!----video frame for playing videos-------->
	<div class="user_video_frame">
	
		<video id="vid_in_frame1" controls>
			  <source src="" type="video/mp4">
			  Your browser does not support the video tag.
		</video>

		<div class="photo_time_location">
			<span class="photo_time"></span>
			<span class="photo_location"></span>
		</div>
		
		<div id="frame_arrow1">
			<img id= "arr_left1" src="img/left_arrow.png"/>
			<img id= "arr_right1" src="img/right_arrow.png"/>
		</div>
	
	</div>

<!----video for playing in the frame-------->
	<ul class="user_photo_disp">
		<?php
			include('connect_db.php');

			$username = $_POST['username'];

			$fetch_user_videos_query = "SELECT * FROM " . $username . "_media WHERE video !=''";
			$fetch_user_videos_query_run = mysqli_query($connect_link, $fetch_user_videos_query);

			$fetch_user_videos_num = mysqli_num_rows($fetch_user_videos_query_run);
			
			if($fetch_user_videos_num == 0)
			{
				echo "no videos found at the moment";
			}
			else
			{
				while($fetch_user_videos_assoc = mysqli_fetch_assoc($fetch_user_videos_query_run))
				{
					$fetch_user_videos_videos = $fetch_user_videos_assoc['video'];
					$fetch_user_videos_time = $fetch_user_videos_assoc['video_time'];
					$fetch_user_videos_location = $fetch_user_videos_assoc['video_location'];
					
					echo "	<li>
								<video>
									  <source location=\"$fetch_user_videos_location\" time=\"" . date('d M Y', strtotime($fetch_user_videos_time)). "\" src=\"vid/".$username, "_video/". $fetch_user_videos_videos."#t=1\" type=\"video/mp4\">
									  Your browser does not support the video tag.
								</video>
							</li>";
				}
			}
			
		?>
	</ul>
</div>


<!------scripts---->
	<script type="text/javascript">
		
	/*---------gallery effect in user video----*/
		$('.user_photo_disp video').click(function()
		{
			$('.user_video_frame').fadeIn(300);

			var src= $(this).find('source').attr('src');
			var time= $(this).find('source').attr('time');
			var location= $(this).find('source').attr('location');

			$('#vid_in_frame1').attr('src',src);
			$('.photo_time').text(time);
			$('.photo_location').text(location);

			current_li = $(this).parent();
			$('#frame_arrow1').show();
		});

		$('#arr_right1').click(function()
		{
			if(current_li.is(':last-child'))
			{
				var new_li = $('.user_photo_disp li').first();
			}
			else
			{
				var new_li = current_li.next();
			}
			
			var new_src = new_li.children('video').find('source').attr('src');
			var new_time= new_li.children('video').find('source').attr('time');
			var new_location= new_li.children('video').find('source').attr('location');

			$('#vid_in_frame1').attr('src',new_src);
			$('.photo_time').text(new_time);
			$('.photo_location').text(new_location);

			current_li = new_li;
		});


		$('#arr_left1').click(function()
		{
			if(current_li.is(':first-child'))
			{
				var new_li = $('.user_photo_disp li').last();
			}
			else
			{
				var new_li = current_li.prev();	
			}
			
			var new_src = new_li.children('video').find('source').attr('src');
			var new_time= new_li.children('video').find('source').attr('time');
			var new_location= new_li.children('video').find('source').attr('location');

			$('#vid_in_frame1').attr('src',new_src);
			$('.photo_time').text(new_time);
			$('.photo_location').text(new_location);

			current_li = new_li;
		});

	</script>