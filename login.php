<?php
	session_start();
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['password']);
	mysql_connect("localhost", "root", "") or die(mysql_error());
	mysql_select_db("unity") or die("Cannot connect to database");
	$query = mysql_query("SELECT * from users WHERE username='$username'");
	$exists = mysql_num_rows($query);
	$table_users = "";
	$table_password = "";
	if($exists>0)
	{
		while($row = mysql_fetch_assoc($query))
		{
			$table_users = $row['username'];
			$table_password = $row['password'];
			$table_Account_active = $row['Account_active'];
		}
		if(($username == $table_users) && ($password == $table_password))
		{
			if($table_Account_active > 0)
			{
				$_SESSION['user'] = $username;
				
				mysql_query("INSERT INTO onlineusers (username) VALUES ('$username')");
				echo "logged";
			}
			else
			{
				echo "Not Active!";
			}
		}
		else
		{
			echo "Incorrect Password!";
		}
	}
	else
	{
		echo "Incorrect Username!";
	}
	mysql_close();
?>