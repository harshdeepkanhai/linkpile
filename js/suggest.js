// tag suggestions for the post form
//
// while you type in the tags box this asks suggest.php for your tags
// that start with the word you are typing, WITHOUT reloading the page.
// it uses XMLHttpRequest (in internet explorer it is an ActiveX object)

var xmlhttp = false;

function getXmlHttp()
{
    var x = false;

    if (window.XMLHttpRequest) {
        // mozilla, firefox, safari
        x = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        // internet explorer
        try {
            x = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                x = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e2) {
                x = false;
            }
        }
    }
    return x;
}

// the word you are typing is everything after the last space
function lastWord()
{
    var v = document.getElementById("tags").value;
    return v.substring(v.lastIndexOf(" ") + 1);
}

// called every time a key goes up in the tags box
function suggestTags()
{
    var word = lastWord();
    var box = document.getElementById("suggest");

    if (word == "") {
        box.style.display = "none";
        return;
    }

    xmlhttp = getXmlHttp();
    if (!xmlhttp) {
        // old browser, no suggestions but the form still works
        return;
    }

    // the time on the end is so IE does not use its cache
    var url = "suggest.php?q=" + encodeURIComponent(word) + "&t=" + new Date().getTime();

    xmlhttp.open("GET", url, true);
    xmlhttp.onreadystatechange = gotTags;
    xmlhttp.send(null);
}

// called when the answer comes back
function gotTags()
{
    // 4 means finished
    if (xmlhttp.readyState != 4) {
        return;
    }
    if (xmlhttp.status != 200) {
        return;
    }

    var box = document.getElementById("suggest");
    var lines = xmlhttp.responseText.split("\n");
    var out = "";

    for (var i = 0; i < lines.length; i++) {
        if (lines[i] == "") {
            continue;
        }
        out = out + "<a href=\"#\" onclick=\"pickTag('" + lines[i] + "'); return false;\">" + lines[i] + "</a> ";
    }

    if (out == "") {
        box.style.display = "none";
    } else {
        box.innerHTML = "your tags: " + out;
        box.style.display = "block";
    }
}

// puts the tag you clicked in place of the word you were typing
function pickTag(tag)
{
    var input = document.getElementById("tags");
    var v = input.value;

    input.value = v.substring(0, v.lastIndexOf(" ") + 1) + tag + " ";
    document.getElementById("suggest").style.display = "none";
    input.focus();
}
