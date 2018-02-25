<div class="user_photo_div">

<!----photo frame for displaying image-------->
	<div class="user_photo_frame">
		
		<img id="pic_in_frame1" src=""/>
		<div class="photo_time_location">
			<span class="photo_time"></span>
			<span class="photo_location"></span>
		</div>

		<div id="frame_arrow1">
			<img id= "arr_left1" src="img/left_arrow.png"/>
			<img id= "arr_right1" src="img/right_arrow.png"/>
		</div>
	
	</div>

<!----photo for displaying in the frame-------->
	<ul class="user_photo_disp">
		<?php
			include('connect_db.php');

			$username = $_POST['username'];

			$fetch_user_photos_query = "SELECT * FROM " . $username . "_media WHERE photo !=''";
			$fetch_user_photos_query_run = mysqli_query($connect_link, $fetch_user_photos_query);

			$fetch_user_photos_num = mysqli_num_rows($fetch_user_photos_query_run);
			
			if($fetch_user_photos_num == 0)
			{
				echo "no photos found at the moment";
			}
			else
			{
				while($fetch_user_photos_assoc = mysqli_fetch_assoc($fetch_user_photos_query_run))
				{
					$fetch_user_photos_photos = $fetch_user_photos_assoc['photo'];
					$fetch_user_photos_time = $fetch_user_photos_assoc['photo_time'];
					$fetch_user_photos_location = $fetch_user_photos_assoc['photo_location'];
					
					echo "	<li>
								<img location=\"$fetch_user_photos_location\" time=\"" . date('d M Y', strtotime($fetch_user_photos_time)). "\" class=\"user_photo_img\" src=\"img/".$username, "_photo/". $fetch_user_photos_photos."\" onerror=\"this.onerror=null;this.src='img/photo_placeholder.png';\">
							</li>";
				}
			}
			
		?>
	</ul>
</div>


<!------scripts---->
	<script type="text/javascript">
		
	/*---------gallery effect user photo----*/
		$('.user_photo_disp img').click(function()
		{
			$('.user_photo_frame').fadeIn(300);

			var src= $(this).attr('src');
			var time= $(this).attr('time');
			var location= $(this).attr('location');

			$('#pic_in_frame1').attr('src',src);
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
			
			var new_src = new_li.children('img').attr('src');
			var new_time= new_li.children('img').attr('time');
			var new_location= new_li.children('img').attr('location');

			$('#pic_in_frame1').attr('src',new_src);
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
			
			var new_src = new_li.children('img').attr('src');
			var new_time= new_li.children('img').attr('time');
			var new_location= new_li.children('img').attr('location');

			$('#pic_in_frame1').attr('src',new_src);
			$('.photo_time').text(new_time);
			$('.photo_location').text(new_location);

			current_li = new_li;
		});

	</script>