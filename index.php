<?php
	include('php/connect_db.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>jan_17</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/index_style.css">
	<script type="text/javascript" src="js/jquery.js"></script>

	<meta name="viewport" content ="width= device-width, initial-scale= 1">
	
</head>
<body>
<!--------top index banner---------->
	<div class="index_banner">
		<img src="img/top.jpeg">
	</div>
	<br>

<!--------login, register and logo image---------->
	<div class="row">
	<!------left side------>
		<div class="col-xs-12 col-md-7 index_logo">
			<img src="img/logo.png">
		</div>

	<!------right side------>
		<div class="log_reg col-xs-12 col-md-5">
			
			<div class="sign_up_text">
				Sign in to your account
			</div>
			<br>

		<!--------login-div-------->
			<div class="login_div">
				<?php
					if(!isset($_COOKIE['signed_username']))
					{
						include('php/login_form.php');
					}
					else
					{
						header('Location: user.php?username=' . $_COOKIE['signed_username']);
					}
					//include('php/login_form.php');
				?>
			</div>
			<br>

		<!--------register div-------->
			<div class="register_div">
				<div class="sign_up_text">
					Create a new account
				</div>
				<br>	

				<input maxlength="50" pattern="[a-zA-Z0-9-]+" type="text" id="name_reg" placeholder="Name" maxlength="25">
				<br>
				<span id="name_feed"></span>
				<br>

				<input maxlength="50" type="text" id="us_name_reg" placeholder="Username" maxlength="25">
				<br>
				<span id="us_name_feed"></span>
				<br>

				<input maxlength="100" type="email" id="email_reg" placeholder="Email">
				<br>
				<span id="email_feed"></span>
				<br>

				<input maxlength="10" type="number" id="mob_reg" placeholder="Mobile Number">
				<br>
				<span id="mob_feed"></span>
				<br>

				<input maxlength="100" type="password" id="pass_reg" placeholder="Password">
				<br>
				<span id="pass_feed"></span>
				<br>

				<button class="register_submit">Sign up</button>
			</div>
			<br>

			<div id="reg_feed"></div>
		</div>
	</div>


<!------scripts------>
<script type="text/javascript">
/*----top banner animation---------*/
	$(window).scroll(function()
	{
		win_pos = $(window).scrollTop();
		//banner_pos = -win_pos;
		$('.index_banner img').css('top', win_pos  + 'px');
	})

//varyfying variables for registration
	name_val = 0;
	us_name_val = 0;
	mob_val = 0;
	email_val = 0;
	pass_val = 0;

/*----name varification--*/
	$('#name_reg').keyup(function()
	{
		var name_reg = $.trim($('#name_reg').val());
		var letters = /^[0-9a-zA-Z ]+$/;
			
		if(name_reg !='')
		{
			if(!name_reg.match(letters))
			{
				name_val = 0;
			}
			else
			{
				name_val = 1;
			}
		}
		else
		{
			name_val = 0;
		}
	});

/*----username varification-----*/
	$('#us_name_reg').keyup(function()
	{
		var us_name_reg= $.trim($('#us_name_reg').val());
		var letters = /^[0-9a-zA-Z]+$/;

		if(us_name_reg!='')
		{
			if(!us_name_reg.match(letters))
			{
				us_name_val = 0;
			}
			else
			{
			//varyfing if that username already exists
				$.post('php/username_existing_varification.php', {us_name_reg: us_name_reg}, function(e)
				{
					if(e==1)
					{
						us_name_val = 1;
					}
					else
					{
						us_name_val = 2;
					}
				});	
			}
		}
		else
		{
			us_name_val = 0;
		}
	});

/*----email varification-----*/
	$('#email_reg').keyup(function()
	{
		var email= $.trim($('#email_reg').val());
		var letters = /^[0-9a-zA-Z .@]+$/;

		if(email!='')
		{
			$.post('php/email.php',{email: email},function(e)
			{	
				if(e=="1")
				{
					if(!email.match(letters))
					{
						email_val = 0;
					}
					else
					{
					//varyfing if that email already exists
						$.post('php/email_existing_varification.php', {email: email}, function(e)
						{
							if(e==1)
							{
								email_val = 1;
							}
							else
							{
								email_val = 2;
							}
						});	
					}	
				}
				else
				{
					email_val = 0;
				}
			});
		}
		else
		{
			email_val = 0;
		}
	});
	
/*--mobile no varification--*/
	$('#mob_reg').keyup(function()
	{
		var mob_reg_length = $('#mob_reg').val().length;

		if(mob_reg_length>10)
		{
			mob_val = 0;
		}
		else if (mob_reg_length == 10)
		{
			mob_val = 1;
		}
		else
		{
			mob_val = 0;
		}
	});

/*----password varification-----*/
	$('#pass_reg').keyup(function()
	{
		var pass_reg = $('#pass_reg').val();
		
		if(pass_reg !='')
		{
			pass_val = 1;
		}
		else
		{	
			pass_val = 0;
		}
	});

/*----on clicking login button-----*/
	$('.register_submit').click(function()
	{
		name_reg = $('#name_reg').val();
		us_name_reg = $('#us_name_reg').val();
		email_reg = $('#email_reg').val();
		mob_reg = $('#mob_reg').val();
		pass_reg = $('#pass_reg').val();

	//name varification
		if(name_val == 0)
		{
			$('#name_feed').text('Kindly enter your name').css('color','red');
		}
		else
		{
			$('#name_feed').text('');
		}

	//username varification
		if(us_name_val == 0)
		{
			$('#us_name_feed').text('Kindly enter an username').css('color','red');
		}
		else if(us_name_val == 2)
		{
			$('#us_name_feed').text('Username already exists, try any other username').css('color','red');
		}
		else
		{
			$('#us_name_feed').text('').css('color','green');
		}
			
	//email varification
		if(email_val == 0)
		{
			$('#email_feed').text('Invalid email address').css('color','red');
		}
		else if(email_val == 2)
		{
			$('#email_feed').text('Email already exists').css('color','red');
		}
		else
		{
			$('#email_feed').text('').css('color','green');
		}

	//mobile number varification
		if(mob_val == 0)
		{
			$('#mob_feed').text('Please enter a valid mobile number').css('color','red');
		}
		else
		{
			$('#mob_feed').text('');
		}

	//password varification
		if(pass_val == 0)
		{
			$('#pass_feed').text('Enter a valid password').css('color','red');
		}
		else
		{
			$('#pass_feed').text('');
		}

		//alert(name_val +''+ us_name_val + email_val + mob_val + pass_val);

	/*----ajax to register the user---*/
		if(name_val==1 && us_name_val == 1 && email_val==1 &&  mob_val ==1 && pass_val == 1)
		{
			$.post('php/register.php', {name_reg : name_reg, us_name_reg: us_name_reg, email_reg : email_reg, mob_reg : mob_reg, pass_reg : pass_reg}, function(e)
			{
				$('#reg_feed').css('padding','3px').css('background', '#00cc44').text(e).delay(4000).fadeOut(1000);
				$('.register_div').fadeOut(0);
			});
		}
		else
		{
			$('#reg_feed').text('Fill all the required fields correctly').css('padding', '3px');
		}

	});

</script>

</body>
</html>