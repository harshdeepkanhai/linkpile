<?php
include("inc/init.php");

$error = "";
$username = "";

if (isset($_POST['username'])) {
    $username = clean($_POST['username']);
    $password = clean($_POST['password']);

    $q = "SELECT id, username FROM users WHERE username = '" . addslashes($username) . "' AND password = '" . md5($password) . "'";
    $res = mysql_query($q) or die(mysql_error());

    if ($row = mysql_fetch_array($res)) {
        // found them
        $_SESSION['uid'] = $row['id'];
        $_SESSION['uname'] = $row['username'];
        $_SESSION['msg'] = "Welcome back, " . $row['username'] . "!";
        header("Location: index.php");
        exit;
    }
    $error = "Wrong username or password.";
}

$title = "Log in";
include("inc/header.php");
?>

<h2>Log in</h2>

<?php if ($error != "") echo "<p class=\"error\">$error</p>\n"; ?>

<form method="post" action="login.php">
<table border="0" cellspacing="0" cellpadding="4">
<tr>
  <td align="right"><b>Username:</b></td>
  <td><input type="text" name="username" size="20" maxlength="32" value="<?php echo html($username); ?>" /></td>
</tr>
<tr>
  <td align="right"><b>Password:</b></td>
  <td><input type="password" name="password" size="20" /></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td><input type="submit" value="Log in" /></td>
</tr>
</table>
</form>

<?php include("inc/footer.php"); ?>
