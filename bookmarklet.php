<?php
include("inc/init.php");

// the bookmarklet opens post.php with the address and title of the
// page you are on. jump=yes sends you back there after saving.
$js = "javascript:location.href='" . $base_url . "/post.php?jump=yes&url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title)";

$title = "Bookmarklet";
include("inc/header.php");
?>

<h2>Post from any page</h2>

<p>A bookmarklet is a small bookmark that runs a bit of JavaScript.
Click it on any web page and it will open <?php echo html($site_name); ?>
with that page's address and title already filled in. After you save,
you go straight back to where you were.</p>

<p class="bookmarklet">
<a href="<?php echo html($js); ?>">post to <?php echo html($site_name); ?></a>
</p>

<h3>Firefox, Mozilla, Opera and Safari</h3>

<p>Drag the link above onto your Bookmarks Toolbar (Personal Toolbar in Mozilla).</p>

<h3>Internet Explorer</h3>

<p>Right click the link above, choose <b>Add to Favorites...</b> and
save it in the <b>Links</b> folder. Click <b>Yes</b> if IE
warns you that the link may not be safe. Make sure the Links toolbar is
showing (View, Toolbars, Links).</p>

<?php include("inc/footer.php"); ?>
