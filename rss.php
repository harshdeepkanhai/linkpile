<?php
// rss 2.0 feeds
//   rss.php                  everybody's bookmarks
//   rss.php?user=NAME        one user
//   rss.php?tag=TAG          everything with a tag
//   rss.php?user=NAME&tag=T  one user's bookmarks with a tag
include("inc/init.php");

$name = "";
$tag = "";
if (isset($_GET['user'])) $name = clean($_GET['user']);
if (isset($_GET['tag'])) $tag = strtolower(clean($_GET['tag']));

$from = "bookmarks b, users u";
$where = "b.user_id = u.id";
$feed_title = $site_name;
$link = $base_url . "/index.php";

if ($name != "") {
	$res = mysql_query("SELECT id, username FROM users WHERE username = '" . addslashes($name) . "'") or die(mysql_error());
	$user = mysql_fetch_array($res);
	if (!$user) {
		die("No such user.");
	}
	$where .= " AND b.user_id = " . $user['id'];
	$feed_title .= ": " . $user['username'];
	$link = $base_url . "/user.php?name=" . urlencode($user['username']);
}

if ($tag != "") {
	$from .= ", tags t";
	$where .= " AND t.bookmark_id = b.id AND t.tag = '" . addslashes($tag) . "'";
	if ($name != "") {
		$feed_title .= "/" . $tag;
		$link .= "&tag=" . urlencode($tag);
	} else {
		$feed_title .= ": " . $tag;
		$link = $base_url . "/tag.php?tag=" . urlencode($tag);
	}
}

$res = mysql_query("SELECT b.*, u.username FROM $from WHERE $where ORDER BY b.created DESC, b.id DESC LIMIT 30") or die(mysql_error());

header("Content-Type: text/xml");
echo "<" . "?xml version=\"1.0\" encoding=\"iso-8859-1\"?" . ">\n";
echo "<rss version=\"2.0\">\n";
echo "<channel>\n";
echo "  <title>" . html($feed_title) . "</title>\n";
echo "  <link>" . html($link) . "</link>\n";
echo "  <description>Bookmarks from " . html($feed_title) . "</description>\n";
echo "  <language>en</language>\n";
echo "  <generator>Linkpile</generator>\n";

while ($row = mysql_fetch_array($res)) {
	echo "  <item>\n";
	echo "    <title>" . html($row['title']) . "</title>\n";
	echo "    <link>" . html($row['url']) . "</link>\n";
	if ($row['notes'] != "") {
		echo "    <description>" . html($row['notes']) . "</description>\n";
	}
	echo "    <author>" . html($row['username']) . "</author>\n";

	$res2 = mysql_query("SELECT tag FROM tags WHERE bookmark_id = " . $row['id'] . " ORDER BY tag") or die(mysql_error());
	while ($row2 = mysql_fetch_array($res2)) {
		echo "    <category>" . html($row2['tag']) . "</category>\n";
	}

	echo "    <pubDate>" . date("r", strtotime($row['created'])) . "</pubDate>\n";
	echo "    <guid isPermaLink=\"false\">linkpile-bookmark-" . $row['id'] . "</guid>\n";
	echo "  </item>\n";
}

echo "</channel>\n";
echo "</rss>\n";
?>
