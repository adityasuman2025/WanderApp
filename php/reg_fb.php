<?php

//checking if the user is already registered or not
    $reg_check_name = $name_reg;
    $reg_check_email = $email_reg;

    $reg_check_query = "SELECT id FROM users WHERE name = '$reg_check_name' AND email = '$reg_check_email'";

    $reg_check_query_run = mysqli_query($connect_link, $reg_check_query);
    $reg_check_num_rows = mysqli_num_rows($reg_check_query_run);

    if($reg_check_num_rows >=1)
    {}
    else
    {
        //registering when no any id is found
        $registration_query = "INSERT INTO users VALUES('','$name_reg','$email_reg','$mob_reg','$pass_reg','0','0','0','0','0')";

        if($registration_query_run = mysqli_query($connect_link, $registration_query))
        {
          echo "Hey $name_reg! You have successfully registered";
        }
        else
        {
          echo 'Something wrong went in your registration';
        }
    }


 //logging the user from fb 

    $email_login = $email_reg;
    $pass_login = $pass_reg;

    $user_login_query = "SELECT id FROM users WHERE email = '$email_login'";
    $user_login_query_run = mysqli_query($connect_link, $user_login_query);
    
    $user_login_num_rows = mysqli_num_rows($user_login_query_run);

    if($user_login_num_rows ==1)
    {
      $user_info_result= mysqli_fetch_row($user_login_query_run);
      $user_info_id = $user_info_result[0];

      setcookie('logged_user_cookie', $user_info_id, time() + 86400, "/");
      
      echo $user_info_id;
    }
    else
    {
      echo 0;
    }

?>