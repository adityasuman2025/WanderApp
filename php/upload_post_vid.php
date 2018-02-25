<?php
	include('connect_db.php');

	if(isset($_COOKIE['signed_username']))
	{
		$username = $_COOKIE['signed_username'];
	}
	else
	{
		$username = 0;
	}

	if($_FILES["file"]["name"] != '')
	{

	//for getting extension of uploaded file
		$test = explode(".", $_FILES["file"]["name"]);
		$image_extension = end($test);

	//setting new name to the pic
		$image_name_new = "vid_" . $username . "." . $image_extension;

	//uploading the pic at temp location
		$image_location = "../vid/tmp_vid/". $image_name_new;
		if(move_uploaded_file($_FILES["file"]["tmp_name"], $image_location))
		{
			echo "	<video>
						<source src=\"vid/tmp_vid/". $image_name_new . "\" type=\"video/mp4\">
						Your browser does not support the video tag.
					</video><br>";
		}
		else
		{
			echo $_FILES["file"]["tmp_name"];
			echo "<br> Something went wrong";
		}

	}
?>