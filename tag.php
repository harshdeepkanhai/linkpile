<?php
include("inc/init.php");

$tag = "";
if (isset($_GET['tag'])) $tag = strtolower(clean($_GET['tag']));
if ($tag == "") {
  header("Location: index.php");
  exit;
}

$stag = addslashes($tag);

$q = "SELECT b.*, u.username FROM bookmarks b, users u, tags t WHERE b.user_id = u.id AND t.bookmark_id = b.id AND t.tag = '$stag' ORDER BY b.created DESC, b.id DESC LIMIT 100";
$res = mysql_query($q) or die(mysql_error());

// related tags = tags that are on the same bookmarks as this one
$q = "SELECT t2.tag, COUNT(*) AS num FROM tags t1, tags t2 WHERE t1.bookmark_id = t2.bookmark_id AND t1.tag = '$stag' AND t2.tag != '$stag' GROUP BY t2.tag ORDER BY num DESC, t2.tag LIMIT 20";
$tres = mysql_query($q) or die(mysql_error());

$rss = $base_url . "/rss.php?tag=" . urlencode($tag);

$title = "Tagged " . $tag;
include("inc/header.php");
?>

<h2>Bookmarks tagged <i><?php echo html($tag); ?></i>
<a class="rss" href="<?php echo html($rss); ?>">RSS</a>
</h2>

<div id="main">
<?php include("inc/bookmark_list.php"); ?>
</div>

<div id="sidebar">
<h3>Related tags</h3>
<?php
if (mysql_num_rows($tres) == 0) {
  echo "<p class=\"empty\">None yet.</p>\n";
}
while ($t = mysql_fetch_array($tres)) {
  echo "<a href=\"tag.php?tag=" . urlencode($t['tag']) . "\">" . html($t['tag']) . "</a> <span class=\"count\">" . $t['num'] . "</span><br />\n";
}
?>
</div>

<br clear="all" />

<?php include("inc/footer.php"); ?>
