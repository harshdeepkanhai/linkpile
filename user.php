<?php
include("inc/init.php");

$name = "";
$tag = "";
if (isset($_GET['name'])) $name = clean($_GET['name']);
if (isset($_GET['tag'])) $tag = strtolower(clean($_GET['tag']));

$res = mysql_query("SELECT * FROM users WHERE username = '" . addslashes($name) . "'") or die(mysql_error());
$user = mysql_fetch_array($res);
if (!$user) {
    $title = "No such user";
    include("inc/header.php");
    echo "<h2>No such user</h2>\n";
    echo "<p>There is nobody called <b>" . html($name) . "</b> here.</p>\n";
    include("inc/footer.php");
    exit;
}
$uid = $user['id'];

if ($tag != "") {
    // only the ones with this tag
    $q = "SELECT b.*, u.username FROM bookmarks b, users u, tags t WHERE b.user_id = u.id AND t.bookmark_id = b.id AND b.user_id = $uid AND t.tag = '" . addslashes($tag) . "' ORDER BY b.created DESC, b.id DESC LIMIT 100";
} else {
    $q = "SELECT b.*, u.username FROM bookmarks b, users u WHERE b.user_id = u.id AND b.user_id = $uid ORDER BY b.created DESC, b.id DESC LIMIT 100";
}
$res = mysql_query($q) or die(mysql_error());

// all the tags of this user for the box on the right
$tres = mysql_query("SELECT t.tag, COUNT(*) AS num FROM tags t, bookmarks b WHERE t.bookmark_id = b.id AND b.user_id = $uid GROUP BY t.tag ORDER BY t.tag") or die(mysql_error());

$link = "user.php?name=" . urlencode($user['username']);

$title = $user['username'];
if ($tag != "") $title .= " / " . $tag;
include("inc/header.php");
?>

<h2><a href="<?php echo $link; ?>"><?php echo html($user['username']); ?></a><?php if ($tag != "") echo " / " . html($tag); ?>
</h2>

<div id="main">
<?php include("inc/bookmark_list.php"); ?>
</div>

<div id="sidebar">
<h3><?php echo html($user['username']); ?>'s tags</h3>
<?php
if (mysql_num_rows($tres) == 0) {
    echo "<p class=\"empty\">No tags yet.</p>\n";
}
while ($t = mysql_fetch_array($tres)) {
    echo "<a href=\"$link&amp;tag=" . urlencode($t['tag']) . "\">" . html($t['tag']) . "</a> <span class=\"count\">" . $t['num'] . "</span><br />\n";
}
?>
<p class="small">member since <?php echo nice_date($user['created']); ?></p>
</div>

<br clear="all" />

<?php include("inc/footer.php"); ?>
