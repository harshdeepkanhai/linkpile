<?php
// some functions that are used all over the place

// takes out the slashes that magic quotes puts in
function clean($str)
{
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return trim($str);
}

// shorter to type than htmlspecialchars
function html($str)
{
    return htmlspecialchars($str);
}

function logged_in()
{
    if (isset($_SESSION['uid'])) {
        return true;
    }
    return false;
}

// 2004-03-14 19:22:00 -> Mar 14, 2004
function nice_date($d)
{
    return date("M j, Y", strtotime($d));
}

// turns "php mysql, web" into an array of tags
function split_tags($str)
{
    $str = strtolower(str_replace(",", " ", $str));
    $tmp = explode(" ", $str);
    $tags = array();
    for ($i = 0; $i < count($tmp); $i++) {
        $t = ereg_replace("[^a-z0-9_.+#-]", "", $tmp[$i]);
        $t = substr($t, 0, 64);
        if ($t != "" && !in_array($t, $tags)) {
            $tags[] = $t;
        }
    }
    return $tags;
}
?>
