<?php
// gives back your tags that start with q, one on each line
// js/suggest.js calls this
include("inc/init.php");

header("Content-Type: text/plain");
// IE keeps the old answer if you dont tell it not to
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

if (!logged_in()) exit;

$q = "";
if (isset($_GET['q'])) $q = strtolower(clean($_GET['q']));
$q = ereg_replace("[^a-z0-9_.+#-]", "", $q);
if ($q == "") exit;

$res = mysql_query("SELECT t.tag, COUNT(*) AS num FROM tags t, bookmarks b WHERE t.bookmark_id = b.id AND b.user_id = " . $_SESSION['uid'] . " AND t.tag LIKE '" . addslashes($q) . "%' GROUP BY t.tag ORDER BY num DESC, t.tag LIMIT 10") or die(mysql_error());

while ($row = mysql_fetch_array($res)) {
    echo $row['tag'] . "\n";
}
?>
