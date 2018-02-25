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
	//for getting old dp name
		$user_cover_query =  "SELECT cover FROM users_info WHERE username = '" . $username . "'";
		$user_cover_query_run = mysqli_query($connect_link , $user_cover_query);
		$user_cover_assoc = mysqli_fetch_assoc($user_cover_query_run);
		$user_cover_name_old = $user_cover_assoc['cover'];

		$user_cover_name_old_break = explode(".", $user_cover_name_old);
		$user_cover_name_old_no = $user_cover_name_old_break[1];

	//for getting extension of uploaded file
		$test = explode(".", $_FILES["file"]["name"]);
		$image_extension = end($test);

	//setting new name of the uploaded dp
		$user_cover_name_new_no = $user_cover_name_old_no + 1;
		$image_name_new = "cover.". $user_cover_name_new_no ."." . $image_extension;

	//updating users_info table with new dp name
		$update_user_cover_query = "UPDATE users_info SET cover ='" . $image_name_new . "' WHERE username = '" . $username . "'";
		$update_user_cover_query_run = mysqli_query($connect_link, $update_user_cover_query);

	//updating photo table of that user
		$update_photo_table_query = "INSERT INTO " . $username . "_media VALUES('', '" . $image_name_new . "', now(), 'Cover Photo', '', '', '')";
		if($update_photo_table_query_run = mysqli_query($connect_link, $update_photo_table_query))
		{
			$image_location = "../img/" . $username . "_photo/". $image_name_new;
			move_uploaded_file($_FILES["file"]["tmp_name"], $image_location);

			echo "<img src=\"img/" . $username . "_photo/". $image_name_new . "\"/> <br><br> successfully uploaded";
		}
		else
		{
			//echo "bad <br>";
		}
	}
?>