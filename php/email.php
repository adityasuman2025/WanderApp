<?php
	//varfying if the typed content is an email or not
	
//if directyly visiting the page
	if(isset($_POST['email']))
	{

	}
	else
	{
		die('not allowed');
	}
	
	$email = htmlentities($_POST['email']);
	$email = strtolower($email);
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		//echo"hi";
		echo "1";
	}
	else
	{
		//echo"bye";
		echo "0";
	}

?>