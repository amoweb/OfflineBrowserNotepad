<?php 
header("Cache-Control: max-age=2592000, public");

?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="bootstrap.min.css" />

<style>
html, body, .container {
  height: 100%;
}
</style>

<script type="text/javascript">

    function getNoteNameFromHash() {
        var h = window.location.hash;
        var posEnd = h.lastIndexOf('@');

        if(posEnd == -1) {
            return h.substr(1);
        } else {
            return h.substr(1, posEnd-1);
        }
    }

    function getPreFromHash() {
        var h = window.location.hash;
        var startPre = h.lastIndexOf('@');

        if(startPre == -1) {
            return 0;
        } else {
            return parseInt(h.substr(startPre+1));
        }
    }

    function gotoPre() {
        var nn = getNoteNameFromHash();
        var nPre = (getPreFromHash() + 1);

        window.location.hash = nn + '@' + nPre;
    }

    function gotoNext() {
        var nn = getNoteNameFromHash();
        var nPre = (getPreFromHash() - 1);

        if(nPre < 0) {
            nPre = 0;
        }

        window.location.hash = nn + '@' + nPre;
    }

    var noteName = getNoteNameFromHash();
    var pre = getPreFromHash();
</script>

</head>
<body>

<b><div id="noteName"></div></b>
Serv{
<a  href="javascript:saveContentsOnline();">Put</a>
<a  href="javascript:readContentsOnline();">Get</a>
<a  href="javascript:gotoPre();">Prev</a>
<a  href="javascript:gotoNext();">Next</a>
}
Local{
<a  href="javascript:saveContentsLocally();" >Put</a>
<a  href="javascript:readContentsLocally();" >Get</a>
}
<a  href="javascript:clearContents();" >Clr</a>
<a  href="javascript:textToSpeech('en-US');" >En</a>
<a  href="javascript:textToSpeech('fr-FR');" >Fr</a>

<textarea id="editor" name="editor" style="min-width: 100%; height: 90%;"></textarea>

<b><div id="noteName"></div></b>
Serv{
<a  href="javascript:saveContentsOnline();">Put</a>
<a  href="javascript:readContentsOnline();">Get</a>
<a  href="javascript:gotoPre();">Prev</a>
<a  href="javascript:gotoNext();">Next</a>
}
Local{
<a  href="javascript:saveContentsLocally();" >Put</a>
<a  href="javascript:readContentsLocally();" >Get</a>
}
<a  href="javascript:clearContents();" >Clr</a>
<a  href="javascript:textToSpeech('en-US');" >En</a>
<a  href="javascript:textToSpeech('fr-FR');" >Fr</a>
</body>

<script src="ckeditor5/ckeditor.js"></script>
<script type="text/javascript">
ClassicEditor
	.create( document.querySelector( '#editor' ), {
		// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
	} )
	.then( editor => {
		window.editor = editor;
	} )
	.catch( err => {
		console.error( err.stack );
	} );

function saveContentsOnline() {
	var contents = window.editor.getData();

	if(contents.length == 0) {
		return;
	}

	if(navigator.onLine) {
		var params = "contents=" + encodeURIComponent(contents);

		const Http = new XMLHttpRequest();
        const url = "recorder.php?nocache=" + (new Date()).getTime() + "&id=" + noteName;
		Http.open("POST", url, true);
		Http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		Http.setRequestHeader("Content-length", params.length);
		Http.setRequestHeader("Connection", "close");
		Http.onload = function () {
			// do something to response
			console.log(this.responseText);
            pre = 0;
            window.location.hash = getNoteNameFromHash();
		};

		Http.send(params);
	} else {
		alert('Offline');
	}
}

function readContentsOnline() {
	if(navigator.onLine) {
		const Http = new XMLHttpRequest();
        const url = "recorder.php?nocache=" + (new Date()).getTime() + "&id=" + noteName + "&pre=" + pre;
		Http.open("GET", url);

		Http.onreadystatechange = (e) => {
            window.editor.setData(Http.responseText);
		}
		Http.send();
	} else {
		alert('Offline');
	}
}

// https://stackoverflow.com/questions/822452/strip-html-from-text-javascript
function stripHtml(html) {
   var tmp = document.createElement("DIV");
   tmp.innerHTML = html;
   return tmp.textContent || tmp.innerText || "";
}

function textToSpeech(lang) {
    if('speechSynthesis' in window) {
        var contents = stripHtml(window.editor.getData());
        var speech = new SpeechSynthesisUtterance(contents);
        speech.lang = lang;
        window.speechSynthesis.speak(speech);
    }
}

function clearContents() {
        window.editor.setData("");
}

function saveContentsLocally() {
	var contents = window.editor.getData();

	if(contents.length == 0) {
		return;
	}
	window.localStorage.setItem('note' + noteName, contents);
}

function readContentsLocally() {
	var contents = window.localStorage.getItem('note' + noteName);

	if(contents == null) {
		alert('Not found locally');
	} else {
		window.editor.setData(contents);
	}
}

function loadContents() {
    // Initial data request
    if(navigator.onLine) {
        readContentsOnline();
    } else {
        readContentsLocally();
    }
}

function onHashChangeDo() {
    noteName = getNoteNameFromHash();
    pre = getPreFromHash();

    if(pre > 0) {
        document.getElementById("noteName").innerHTML = "Note " + noteName + "@" + pre;
    } else {
        document.getElementById("noteName").innerHTML = "Note " + noteName;
    }

    loadContents();
}


onHashChangeDo();
window.onhashchange = onHashChangeDo;

</script>

</html>
