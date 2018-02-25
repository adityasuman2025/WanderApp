<?php
	//deleting cookie for logging out
	if(setcookie('signed_username', '' , time() - 2147483647, "/"))
	{
		echo 1;	
	}
	else
	{
		echo 0;
	}

 ?>