<?php
	//registering users into database

	include('connect_db.php');

	$name_reg = htmlentities(mysqli_real_escape_string($connect_link,$_POST['name_reg']));
	$us_name_reg = strtolower(htmlentities(mysqli_real_escape_string($connect_link,$_POST['us_name_reg'])));
	$email_reg = strtolower(htmlentities(mysqli_real_escape_string($connect_link,$_POST['email_reg'])));
	$mob_reg = htmlentities(mysqli_real_escape_string($connect_link,$_POST['mob_reg']));
	$pass_reg =  htmlentities(mysqli_real_escape_string($connect_link, md5($_POST['pass_reg'])));
	
	$registration_query = "INSERT INTO users VALUES('','$name_reg', '$us_name_reg', '$email_reg','$mob_reg','$pass_reg')";
	$user_info_entry_query = "INSERT INTO users_info VALUES('','$name_reg', '$us_name_reg', '','dp.0.jpg','cover.0.jpg', '', '', '', '', '' ,'', '')";
	
	$create_info_table = "CREATE TABLE " . $us_name_reg . "_info (id INT(255) AUTO_INCREMENT PRIMARY KEY, bucket VARCHAR(100), passion VARCHAR(100), travel VARCHAR(100), comp VARCHAR(100), block VARCHAR(100), comp_rqst VARCHAR(100))";
	$create_media_table = "CREATE TABLE " . $us_name_reg . "_media (id INT(255) AUTO_INCREMENT PRIMARY KEY, photo VARCHAR(100), photo_time DATE, photo_location VARCHAR(100), video VARCHAR(100), video_time DATE, video_location VARCHAR(100))";
	$create_post_table = "CREATE TABLE " . $us_name_reg . "_post (id INT(255) AUTO_INCREMENT PRIMARY KEY, text VARCHAR(10000), photo VARCHAR(100), video VARCHAR(100), location VARCHAR(100), time DATE)";
	$create_message_table = "CREATE TABLE " . $us_name_reg . "_message (id INT(255) AUTO_INCREMENT PRIMARY KEY, message_by VARCHAR(100), message VARCHAR(10000), time timestamp, view VARCHAR(10))";
	
	// $create_photo_table = "CREATE TABLE " . $us_name_reg . "_photo (id INT(255) AUTO_INCREMENT PRIMARY KEY, photo VARCHAR(100), time DATE, location VARCHAR(100))";
	// $create_video_table = "CREATE TABLE " . $us_name_reg . "_video (id INT(255) AUTO_INCREMENT PRIMARY KEY, video VARCHAR(100), time DATE, location VARCHAR(100))";
	// $create_comp_column = "ALTER TABLE companion ADD " . $us_name_reg . "_comp VARCHAR(100)";
	// $create_block_column = "ALTER TABLE companion ADD " . $us_name_reg . "_block VARCHAR(100)";

	mkdir("../img/" . $us_name_reg. "_photo" );
	mkdir("../vid/" . $us_name_reg. "_video" ); 

	$create_info_table_run = mysqli_query($connect_link, $create_info_table);
	$create_media_table_run = mysqli_query($connect_link, $create_media_table);
	$create_post_table_run =mysqli_query($connect_link, $create_post_table);
	$create_message_table_run =mysqli_query($connect_link, $create_message_table);

	//$create_photo_table_run = mysqli_query($connect_link, $create_photo_table);
	//$create_video_table_run = mysqli_query($connect_link, $create_video_table);
	// $create_comp_column_run = mysqli_query($connect_link, $create_comp_column);
	// $create_block_column_run =mysqli_query($connect_link, $create_block_column);
	
	if($registration_query_run = mysqli_query($connect_link, $registration_query) && $user_info_entry_query_run = mysqli_query($connect_link, $user_info_entry_query))
	{
		echo "Hey $name_reg! You have successfully registered";
	}
	else
	{
		echo 'Something wrong went in your registration';
	}
?>