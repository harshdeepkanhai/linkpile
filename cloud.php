<?php
include("inc/init.php");

$res = mysql_query("SELECT tag, COUNT(*) AS num FROM tags GROUP BY tag ORDER BY tag") or die(mysql_error());

// find the smallest and the biggest count first
$min = 0;
$max = 0;
while ($row = mysql_fetch_array($res)) {
	if ($min == 0 || $row['num'] < $min) $min = $row['num'];
	if ($row['num'] > $max) $max = $row['num'];
}

$title = "Tags";
include("inc/header.php");
?>

<h2>All tags</h2>

<?php
if (mysql_num_rows($res) == 0) {
	echo "<p class=\"empty\">No tags yet.</p>\n";
} else {
	// go back to the first row and print them
	mysql_data_seek($res, 0);

	echo "<p id=\"cloud\">\n";
	while ($row = mysql_fetch_array($res)) {
		// font size from 10px to 26px
		if ($max == $min) {
			$size = 14;
		} else {
			$size = 10 + round(16 * ($row['num'] - $min) / ($max - $min));
		}
		echo "<a style=\"font-size: " . $size . "px\" href=\"tag.php?tag=" . urlencode($row['tag']) . "\" title=\"" . $row['num'] . " bookmarks\">" . html($row['tag']) . "</a>\n";
	}
	echo "</p>\n";
}
?>

<?php include("inc/footer.php"); ?>
