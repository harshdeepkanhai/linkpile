<?php
if (!isset($title)) $title = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if ($title != "") echo html($title) . " - "; echo html($site_name); ?></title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

<table id="page" width="760" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
  <td id="header">
    <h1><a href="index.php"><?php echo html($site_name); ?></a></h1>
    <div id="nav">
      <a href="index.php">home</a> |
<?php if (logged_in()) { ?>
      logged in as <b><?php echo html($_SESSION['uname']); ?></b> |
      <a href="logout.php">log out</a>
<?php } else { ?>
      <a href="login.php">log in</a>
<?php } ?>
    </div>
  </td>
</tr>
<tr>
  <td id="content">
<?php
// message from the page before
if (isset($_SESSION['msg'])) {
    echo "<p class=\"msg\">" . html($_SESSION['msg']) . "</p>\n";
    unset($_SESSION['msg']);
}
?>
