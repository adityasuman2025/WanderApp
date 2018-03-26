<?php
	$mysql_host = "localhost";
	$mysql_user = "root";
	$mysql_pass = "";
	$mysql_db = "jan_18";

	if($connect_link = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db))
	{
		//echo 'done';
	}
	else
	{
		echo 'database failed to connect';
	}

//getting location of the user using its ip address and setting the timezone of php according to it
	$ip=$_SERVER['REMOTE_ADDR'];
	$arr_locaton = file_get_contents('http://freegeoip.net/json/' . $ip);
	//print_r(json_decode($arr_locaton));

	$location_array = json_decode($arr_locaton, true); //converts stdClass object into arrray

	$timezone = $location_array['time_zone'];

	if($timezone == '')
	{
		$timezone = "Asia/Kolkata";
	}

	date_default_timezone_set($timezone); //setting the timezone of that user

//setting the timezone of the mysql server
	// $now = new DateTime();
	// $mins = $now->getOffset() / 60;
	// $sgn = ($mins < 0 ? -1 : 1);
	// $mins = abs($mins);
	// $hrs = floor($mins / 60);
	// $mins -= $hrs * 60;
	// $offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);

	// //Your DB Connection - sample
	// $db = new PDO('mysql:host=localhost;dbname=jan_18', $mysql_user, $mysql_pass);

	// if($db->exec("SET time_zone='$offset';"))
	// {
	// 	echo 'gyd';
	// }
	// else
	// {
	// 	echo 'bad';
	// }
?>