<?php
include("inc/init.php");

if (!logged_in()) {
	$_SESSION['msg'] = "Please log in first.";
	header("Location: login.php");
	exit;
}

$id = 0;
if (isset($_REQUEST['id'])) $id = intval($_REQUEST['id']);

// make sure it is really theirs
$res = mysql_query("SELECT * FROM bookmarks WHERE id = $id AND user_id = " . $_SESSION['uid']) or die(mysql_error());
$row = mysql_fetch_array($res);
if (!$row) {
	$_SESSION['msg'] = "You can only delete your own bookmarks.";
	header("Location: index.php");
	exit;
}

$back = "user.php?name=" . urlencode($_SESSION['uname']);

if (isset($_POST['confirm'])) {
	mysql_query("DELETE FROM tags WHERE bookmark_id = $id") or die(mysql_error());
	mysql_query("DELETE FROM bookmarks WHERE id = $id") or die(mysql_error());

	$_SESSION['msg'] = "Bookmark deleted.";
	header("Location: $back");
	exit;
}

$title = "Delete bookmark";
include("inc/header.php");
?>

<h2>Delete bookmark</h2>

<p>Really delete <b><?php echo html($row['title']); ?></b>?</p>

<form method="post" action="delete.php">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="confirm" value="yes" />
<input type="submit" value="Delete" />
or <a href="<?php echo $back; ?>">cancel</a>
</form>

<?php include("inc/footer.php"); ?>
