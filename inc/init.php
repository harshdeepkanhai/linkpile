<?php
// this gets included at the top of every page

if (!file_exists("config.php")) {
	die("config.php not found. Copy config.php.dist to config.php and edit it.");
}

include("config.php");
include("inc/db.php");
include("inc/functions.php");

session_start();
?>
