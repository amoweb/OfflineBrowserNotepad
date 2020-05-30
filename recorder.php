<?php
include "co.lib.php";

header("Access-Control-Allow-Origin: *");

$id = 0;
if(array_key_exists('id', $_GET)) {
    $id = sanitizeId($_GET['id']);
}

$noteFileName = $NOTES_DIR . $id . ".json";

// Read the existing note, or create a new one
$note = readJson($noteFileName);
if($note == null) {
    $d = time();
    $note = new stdClass();
    $note->key = "";
    $note->dateUpdated = $d;
    $note->dateCreated = $d;
    $note->readOnly = false;
    $note->previousFile = "";
    $note->revision = 0;
}

// Check key
if(strcmp($note->key, "") != 0) {
    if(!array_key_exists('key', $_GET) || strcmp($note->key, $_GET['key']) != 0) {
        die('Bad key.');
    }
}

// The user update the file
$contents = '';
if(array_key_exists('contents', $_POST)) {

    $contents = $_POST['contents'];

    $note->revision++;
    $contentsFileName = $NOTES_DIR . strval($id) . '_' . $note->revision . ".txt";
    file_put_contents($contentsFileName, $contents);
    writeJson($noteFileName, $note);
} else {
    // Read contents from last revision or a previous
    if(array_key_exists('pre', $_GET)) {
        $revision = max(0, intval($_GET['pre']));
    } else {
        $revision = 0;
    }

    if($note->revision - $revision < 1) {
        $contents = "<b>This previous state does not exist.</b>";
    } else {
        $contentsFileName = $NOTES_DIR . strval($id) . '_' . max(1, $note->revision - $revision) . ".txt";
        if(file_exists($contentsFileName)) {
            $contents = file_get_contents($contentsFileName);
        } else {
            $contents = "<b>Note not found.</b>";
        }
    }
}

echo $contents;

?>
