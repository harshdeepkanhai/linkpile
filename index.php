<?php
include("inc/init.php");

include("inc/header.php");
?>

<?php if (!logged_in()) { ?>
<p class="intro">Linkpile keeps your bookmarks on the web, so you can reach
them from any computer. Tag your links with simple words and see what
other people are saving.
</p>
<?php } ?>

<h2>Welcome</h2>

<p>There is not much to see here yet. Saving bookmarks is coming soon!</p>

<?php include("inc/footer.php"); ?>
