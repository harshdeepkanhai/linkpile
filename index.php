<?php
include("inc/init.php");

$q = "SELECT b.*, u.username FROM bookmarks b, users u WHERE b.user_id = u.id ORDER BY b.created DESC, b.id DESC LIMIT 25";
$res = mysql_query($q) or die(mysql_error());

include("inc/header.php");
?>

<?php if (!logged_in()) { ?>
<p class="intro">Linkpile keeps your bookmarks on the web, so you can reach
them from any computer. Tag your links with simple words and see what
other people are saving.
<a href="register.php">Sign up</a>, it's free.
</p>
<?php } ?>

<h2>Recently saved</h2>

<?php include("inc/bookmark_list.php"); ?>

<?php include("inc/footer.php"); ?>
