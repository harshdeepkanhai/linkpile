<?php
// connect to mysql

$db = @mysql_connect($db_host, $db_user, $db_pass) or die("Could not connect to mysql: " . mysql_error());
mysql_select_db($db_name, $db) or die("Could not select the database: " . mysql_error());
?>
