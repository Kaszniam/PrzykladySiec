<?php
         
            mysql_connect("localhost", "root", "") or die(mysql_error());
            mysql_select_db("unity") or die(mysql_error());
			if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash']))
			{
				$email = mysql_escape_string($_GET['email']);
				$hash = mysql_escape_string($_GET['hash']);
			}
            $search = mysql_query("SELECT email, Active_key, Account_active FROM users WHERE email='".$email."' AND Active_key='".$hash."' AND Account_active='0'") or die(mysql_error()); 
			$match  = mysql_num_rows($search);
			if($match>0)
			{
				mysql_query("UPDATE users SET Account_active='1' WHERE email='".$email."' AND Active_key='".$hash."' AND Account_active='0'") or die(mysql_error());
				echo '<div class="statusmsg">Your account has been activated, you can now login</div>';
			}
			else
			{
				echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
			}
?>