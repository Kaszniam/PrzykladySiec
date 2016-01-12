<?php

		$username = mysql_real_escape_string($_POST['username']);
		$password = mysql_real_escape_string($_POST['password']);
		$email = mysql_real_escape_string($_POST['email']);
		$bool = true;
		$error = false;
		if(strlen($username)<3 && !$error)
		{
			$error = true;
			echo "Username too short!";
		}
		if(strlen($username)>20 && !$error)
		{
			$error = true;
			echo "Username too long!";
		}
		if(strlen($password)<5 && !$error)
		{
			$error = true;
			echo "Password too short!";
		}
		if(strlen($password)>20 && !$error)
		{
			$error = true;
			echo "Password too long!";
		}
		if(empty($email) && !$error)
		{
			$error = true;
			echo "Email cannot be empty!";
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$error = true;
			echo "Please write correct email!";
		}
		if(!$error)
		{
			mysql_connect("localhost", "root", "") or die(mysql_error());
			mysql_select_db("unity") or die("Cannot connect to database");
			$query = mysql_query("Select * from users");
			while($row = mysql_fetch_array($query))
			{
				$table_users = $row['username'];
				if($username == $table_users)
				{
					$bool = false;
					echo "Username already taken!";
				}
				else
				{
					if($email == $table_users)
					{
						$bool = false;
						echo "Email already taken!";
					}
				}
			}
			if($bool)
			{
				$hash = md5(rand(0,1000));
				mysql_query("INSERT INTO users (username, password, email, Account_active, Active_key) VALUES ('$username','$password', '$email', '0', '$hash')");
				echo "signedin";
				$to = $email;
				$subject = 'Verification';
				$message = '
				
	Thanks for signing up!
	Your account has been created, you can login just after you have activated your account by pressing the url below.\r\n

	------------------------
	Username: '.$username.'
	Password: '.$password.'
	------------------------
					
	Please click this link to activate your account:
	http://www.yourwebsite.com/verify.php?email='.$email.'&hash='.$hash.'
					 
	';
									 
				$headers = 'From:noreply@yourwebsite.com' . "\r\n";
				mail($to, $subject, $message, $headers);
			}
		}
?>