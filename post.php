<?php
include("inc/init.php");

if (!logged_in()) {
    $_SESSION['msg'] = "Please log in first.";
    header("Location: login.php");
    exit;
}

$error = "";
$url = "";
$bm_title = "";
$notes = "";
$tags = "";

// the bookmarklet sends us the address and title of the page
if (isset($_GET['url'])) $url = clean($_GET['url']);
if (isset($_GET['title'])) $bm_title = clean($_GET['title']);

// jump=yes means go back to that page after saving
$jump = "";
if (isset($_REQUEST['jump'])) $jump = clean($_REQUEST['jump']);

// are we editing one?
$id = 0;
if (isset($_REQUEST['id'])) $id = intval($_REQUEST['id']);
if ($id > 0) {
    $q = "SELECT * FROM bookmarks WHERE id = $id AND user_id = " . $_SESSION['uid'];
    $res = mysql_query($q) or die(mysql_error());
    $row = mysql_fetch_array($res);
    if (!$row) {
        $_SESSION['msg'] = "You can only edit your own bookmarks.";
        header("Location: index.php");
        exit;
    }
    $url = $row['url'];
    $bm_title = $row['title'];
    $notes = $row['notes'];

    $res = mysql_query("SELECT tag FROM tags WHERE bookmark_id = $id ORDER BY tag") or die(mysql_error());
    while ($row = mysql_fetch_array($res)) {
        $tags .= $row['tag'] . " ";
    }
    $tags = trim($tags);
}

if (isset($_POST['url'])) {
    $url = clean($_POST['url']);
    $bm_title = clean($_POST['title']);
    $notes = clean($_POST['notes']);
    $tags = clean($_POST['tags']);

    if (!eregi('^(http|https|ftp)://[^[:space:]]+$', $url) || strlen($url) > 255) {
        $error = "Please enter a full URL starting with http://";
    }
    if ($bm_title == "") $bm_title = $url;

    if ($error == "") {
        if ($id > 0) {
            $q = "UPDATE bookmarks SET url = '" . addslashes($url) . "', title = '" . addslashes($bm_title) . "', notes = '" . addslashes($notes) . "' WHERE id = $id";
            mysql_query($q) or die(mysql_error());
            // easier to throw all the old tags away and put them back in
            mysql_query("DELETE FROM tags WHERE bookmark_id = $id") or die(mysql_error());
            $_SESSION['msg'] = "Bookmark updated.";
        } else {
            $q = "INSERT INTO bookmarks (user_id, url, title, notes, created) VALUES (" . $_SESSION['uid'] . ", '" . addslashes($url) . "', '" . addslashes($bm_title) . "', '" . addslashes($notes) . "', NOW())";
            mysql_query($q) or die(mysql_error());
            $id = mysql_insert_id();
            $_SESSION['msg'] = "Bookmark saved.";
        }

        $t = split_tags($tags);
        for ($i = 0; $i < count($t); $i++) {
            mysql_query("INSERT INTO tags (bookmark_id, tag) VALUES ($id, '" . addslashes($t[$i]) . "')") or die(mysql_error());
        }

        if ($jump == "yes") {
            header("Location: $url");
            exit;
        }
        header("Location: user.php?name=" . urlencode($_SESSION['uname']));
        exit;
    }
}

if ($id > 0) {
    $title = "Edit bookmark";
} else {
    $title = "Post a bookmark";
}
include("inc/header.php");
?>

<h2><?php echo $title; ?></h2>

<?php if ($error != "") echo "<p class=\"error\">$error</p>\n"; ?>

<form method="post" action="post.php">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="jump" value="<?php echo html($jump); ?>" />
<table border="0" cellspacing="0" cellpadding="4">
<tr>
  <td align="right"><b>URL:</b></td>
  <td><input type="text" name="url" size="60" maxlength="255" value="<?php echo html($url); ?>" /></td>
</tr>
<tr>
  <td align="right"><b>Title:</b></td>
  <td><input type="text" name="title" size="60" maxlength="255" value="<?php echo html($bm_title); ?>" /></td>
</tr>
<tr>
  <td align="right" valign="top"><b>Notes:</b></td>
  <td><textarea name="notes" rows="4" cols="50"><?php echo html($notes); ?></textarea></td>
</tr>
<tr>
  <td align="right" valign="top"><b>Tags:</b></td>
  <td><input type="text" name="tags" size="60" value="<?php echo html($tags); ?>" /><br />
  <font size="1" color="#666666">separated by spaces</font></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td><input type="submit" value="Save" /></td>
</tr>
</table>
</form>

<p class="small">Tip: get the <a href="bookmarklet.php">bookmarklet</a> and post
from any page with one click.</p>

<?php include("inc/footer.php"); ?>
