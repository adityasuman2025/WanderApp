<?php 
	//user login form
?>

<div class="login_user">
	<input maxlength="100" type="email" id="email_login" placeholder="Email">
	<br><br>

	<input maxlength="100" id="pass_login" type="password" placeholder="Password">
	<br>

	<span class="forgot_pass">Forgot Password</span>
	<br><br>

	<button class="login_submit">Login</button>
	<br>
	<span id="login_feed"></span>
	<br><br>

	<div class="fb-login-button" size="large" data-scope = "public_profile,email" onlogin="checkLoginState();">
		Login From Facebook
	</div>
</div>

<div class="forgot_div">
	Enter your registered Email
	<br>

	<input maxlength="100" type="email" id="email_forgot"/>
	<br><br>

	<button class="back_to_login">Go Back</button>
	<button class="forgot_button">Submit</button>
	<br>

	<span class="forgot_feed"></span>
</div>

<div class="recovery_div">
	Enter the secret code mailed to
	<br>
	<span class="recovery_email"></span>
	<br>

	<input maxlength="100" type="text" id="recovery_code"/>
	<br><br>

	<button class="recovery_button">Submit</button>
	<br>

	<span class="recovery_feed"></span>
</div>

<div class="new_pass_div">
	<input type="password" maxlength="100" placeholder="enter your new password" id="new_pass_input"/>
	<br><br>

	<input type="password" maxlength="100" placeholder="confirm your password" id="new_pass_cnfrm_input"/>
	<br><br>

	<button class="new_pass_button">Set</button>
	<br>
	<span class="new_pass_feed"></span>
	<br>

	<button class="back_to_login">Login</button>
	<br>
</div>

<script type="text/javascript">
/*-----on clicking login submit button--------*/
	$('.login_submit').click(function()
	{
		email_login = $('#email_login').val();
		pass_login = $('#pass_login').val();

		$.post('php/user_login.php',{email_login: email_login, pass_login: pass_login }, function(e)
		{
			logged_username= e;

			if(e==0)
			{
				$('#login_feed').text('Your email and password combination do not match').css('color','red');
			}
			else
			{
				$('#login_feed').text("You have successfully logged in").css('color','#00cc44');
			//JQuery code to redirect a page or URL
               var url = "user.php?username=" + logged_username;
               $(location).attr('href',url);
			}

		});
	});

/*-----script for forgot password-----*/
	$('.forgot_pass').click(function()
	{
		$('.login_user').fadeOut(0);
		$('.forgot_div').fadeIn(0);
	});

/*-----on clicking on back to login button-----*/
	$('.back_to_login').click(function()
	{
		$('.login_user').fadeIn(0);
		$('.forgot_div').fadeOut(0);
		$('.new_pass_div').fadeOut(0);
	});

/*-----on clicking on submit button of forgot password-----*/
	$('.forgot_button').click(function()
	{
	//varyfing if that email already exists
		email= $.trim($('#email_forgot').val());	

		$.post('php/email_existing_varification.php', {email: email}, function(e)
		{
			if(e==1)
			{
				$('.forgot_feed').text('This is not a registered email address').css('color','red');
			}
			else
			{	
				random_no = Math.floor((Math.random() * 1000) + 1);

				mail_email = email;
				mail_subject = "Password Recovery for your account";
				mail_body = "Here is your code for recovering your forgotten password \n \n" + random_no + "\n \n \n Thanks \n Travel";
				mail_header = "From: Catchfreedeal <info@catchfreedeal.com>";
				
				$.post('php/mailing.php', {mail_email: mail_email, mail_subject: mail_subject, mail_body: mail_body , mail_header: mail_header}, function(f)
				{
					if(f == 1)
					{
						$('.forgot_feed').text('mail is successfully sent to your email address').css('color','#00cc44');

						$('.recovery_div').fadeIn(100);
						$('.forgot_div').fadeOut(0);
						$('.recovery_email').text(email);
					}
					else
					{
						$('.forgot_feed').text('something went wrong while mailing you').css('color','red');
					}
				});
			}
		});

	});

/*----for the recovery div-----*/
	$('.recovery_button').click(function()
	{
		recovery_code = $.trim($('#recovery_code').val());
		recovery_email= mail_email;
		
		if(recovery_code == random_no)
		{
			$('.recovery_div').fadeOut(0);
			$('.new_pass_div').fadeIn(0);

			//alert('works');
			$('.new_pass_button').click(function()
			{
				new_password = $.trim($('#new_pass_input').val());
				new_cnfrm_password = $.trim($('#new_pass_cnfrm_input').val());

				if(new_password == new_cnfrm_password & new_password != '')
				{
					$.post('php/recover_pass.php', {new_password: new_password , recovery_email: recovery_email}, function(g)
					{
						if(g == 1)
						{
							$('.new_pass_feed').text('Congrats! You have successfully changed your password.').css('color','#00cc44');
							$('.forgot_pass').fadeOut(0);
						}
						else
						{
							$('.new_pass_feed').text('Something went wrong! Your password failed to change.').css('color', 'red');
						}
					});
				}
				else
				{
					$('.new_pass_feed').text('Your password do not match or your input is blank. Please try again').css('color', 'red');
				}
				
			});			
		}
		else
		{
			$('.recovery_feed').text('Your code do not match').css('color', 'red');
		}
	});

</script>