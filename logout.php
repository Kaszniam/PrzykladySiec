<?php
    session_start();
	$username = mysql_real_escape_string($_POST['username']);
	mysql_connect("localhost", "root", "") or die(mysql_error());
	mysql_select_db("unity") or die("Cannot connect to database");
	mysql_query("DELETE FROM onlineusers WHERE username='$username'");
    session_destroy();
    mysql_close();
?>