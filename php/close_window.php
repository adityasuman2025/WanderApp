<?php
	$ip = $_SERVER["REMOTE_ADDR"];
	date_default_timezone_set('Asia/Kolkata');
	$time = date ("H:i:s", time());
	$date = date ("d M Y", time());
	
	$handleip =fopen('ip.txt', 'a');
	fwrite($handleip, "0");

	echo "gud";
?>