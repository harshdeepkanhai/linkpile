<?php
// prints out the bookmarks in $res

if (mysql_num_rows($res) == 0) {
    echo "<p class=\"empty\">No bookmarks here yet.</p>\n";
}

while ($row = mysql_fetch_array($res)) {
    echo "<div class=\"bm\">\n";
    echo "<a class=\"bmtitle\" href=\"" . html($row['url']) . "\">" . html($row['title']) . "</a>\n";
    if ($row['notes'] != "") {
        echo "<div class=\"notes\">" . nl2br(html($row['notes'])) . "</div>\n";
    }
    echo "<div class=\"meta\">";

    // get the tags for this bookmark
    $res2 = mysql_query("SELECT tag FROM tags WHERE bookmark_id = " . $row['id'] . " ORDER BY tag") or die(mysql_error());
    if (mysql_num_rows($res2) > 0) {
        echo "to ";
        while ($row2 = mysql_fetch_array($res2)) {
            echo html($row2['tag']) . " ";
        }
    }

    echo "by " . html($row['username']);
    echo " on " . nice_date($row['created']);
    echo "</div>\n";
    echo "</div>\n";
}
?>
