<?php
include("inc/init.php");

if (logged_in()) {
    header("Location: index.php");
    exit;
}

$error = "";
$username = "";
$email = "";

if (isset($_POST['username'])) {
    $username = clean($_POST['username']);
    $email = clean($_POST['email']);
    $password = clean($_POST['password']);
    $password2 = clean($_POST['password2']);

    // check everything
    if (!ereg('^[A-Za-z0-9_]{3,32}$', $username)) {
        $error .= "Username must be 3 to 32 letters, numbers or underscores.<br />";
    }
    if (!ereg('^[^@[:space:]]+@[^@[:space:]]+\.[^@[:space:]]+$', $email)) {
        $error .= "Please enter a valid email address.<br />";
    }
    if (strlen($password) < 6) {
        $error .= "Password must be at least 6 characters.<br />";
    }
    if ($password != $password2) {
        $error .= "The two passwords do not match.<br />";
    }

    if ($error == "") {
        $q = "SELECT id FROM users WHERE username = '" . addslashes($username) . "'";
        $res = mysql_query($q) or die(mysql_error());
        if (mysql_num_rows($res) > 0) {
            $error .= "That username is already taken.<br />";
        }
    }

    if ($error == "") {
        $q = "INSERT INTO users (username, password, email, created) VALUES ('" . addslashes($username) . "', '" . md5($password) . "', '" . addslashes($email) . "', NOW())";
        mysql_query($q) or die(mysql_error());

        // log them in straight away
        $_SESSION['uid'] = mysql_insert_id();
        $_SESSION['uname'] = $username;
        $_SESSION['msg'] = "Welcome to Linkpile, $username!";
        header("Location: index.php");
        exit;
    }
}

$title = "Register";
include("inc/header.php");
?>

<h2>Create an account</h2>

<?php if ($error != "") echo "<p class=\"error\">$error</p>\n"; ?>

<form method="post" action="register.php">
<table border="0" cellspacing="0" cellpadding="4">
<tr>
  <td align="right"><b>Username:</b></td>
  <td><input type="text" name="username" size="20" maxlength="32" value="<?php echo html($username); ?>" /></td>
</tr>
<tr>
  <td align="right"><b>Email:</b></td>
  <td><input type="text" name="email" size="30" maxlength="100" value="<?php echo html($email); ?>" /></td>
</tr>
<tr>
  <td align="right"><b>Password:</b></td>
  <td><input type="password" name="password" size="20" /></td>
</tr>
<tr>
  <td align="right"><b>Password again:</b></td>
  <td><input type="password" name="password2" size="20" /></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td><input type="submit" value="Register" /> <font size="1" color="#666666">it's free</font></td>
</tr>
</table>
</form>

<?php include("inc/footer.php"); ?>
