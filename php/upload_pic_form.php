<div class="upload_what">
	<?php
		echo $upload_what = $_POST['upload_what'];
	?>
</div>

<input type="file" name="file" id="file" accept="image/jpeg, image/png"/>
<br>
<div class="upload_pic_feed"></div>

<ul class="upload_ins">
	<li>Image size must be less than 1 MB.</li>
	<li>Video size must be less than 20 MB.</li>
</ul>

<button class="upload_done">Done</button>


<!--------script------>
	<script type="text/javascript">
	/*----for uploading pic----*/
		upload_what = $.trim($('.upload_what').text());

		$(document).on('change', '#file', function()
		{
			var property = document.getElementById("file").files[0];
			var image_name = property.name;
			var image_extension = image_name.split('.').pop().toLowerCase();
			var image_size = property.size;

			if(jQuery.inArray(image_extension, ['jpg', 'jpeg', 'png']) == -1)
			{
				alert("Choose a valid image file");
			}
			else
			{
				if(image_size > 1000000)
				{
					alert('Image File Size is more than 1 MB');
				}
				else
				{
					var form_data = new FormData();
					form_data.append("file", property);

					$.ajax({
						url: "php/upload_" + upload_what + ".php",
						method: "POST",
						data: form_data,
						contentType: false,
						cache: false,
						processData: false,
						beforeSend:function()
						{
							$('.upload_pic_feed').text('Uploading...');
						},
						success: function(data)
						{
							$('.upload_pic_feed').html(data);

							$('#file').fadeOut(0);
							$('.upload_ins').fadeOut(0);

							$('.upload_done').fadeIn(0);
						}
					});

				}

			}
			
		});

	/*-on clicking upload done------*/
		$('.upload_done').click(function()
		{
			location.reload();
		});
	</script>