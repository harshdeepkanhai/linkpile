<?php
include("inc/init.php");

// the links that the most people saved in the last week
$q = "SELECT url, COUNT(DISTINCT user_id) AS saves, MAX(id) AS latest FROM bookmarks WHERE created > DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY url ORDER BY saves DESC, latest DESC LIMIT 25";
$pres = mysql_query($q) or die(mysql_error());

$title = "Popular";
include("inc/header.php");
?>

<h2>Popular this week</h2>

<?php
if (mysql_num_rows($pres) == 0) {
    echo "<p class=\"empty\">No bookmarks here yet.</p>\n";
}

while ($p = mysql_fetch_array($pres)) {
    // show the newest copy of each link
    $saves = $p['saves'];
    $res = mysql_query("SELECT b.*, u.username FROM bookmarks b, users u WHERE b.user_id = u.id AND b.id = " . $p['latest']) or die(mysql_error());
    include("inc/bookmark_list.php");
}
?>

<?php include("inc/footer.php"); ?>
