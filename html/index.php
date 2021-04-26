<?php include "../co.lib.php" ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    img {
      max-width: 100vw;
    }
</style>
</head>
<body>

<?php
    $id = 0;
    if(array_key_exists('id', $_GET)) {
        $id = sanitizeId($_GET['id']);
    }

    $noteFileName = '../' . $NOTES_DIR . strval($id) . ".json";
    $note = readJson($noteFileName);

    if($note == null) {
        die('note not found');
    }

    // Check key
    if(strcmp($note->key, "") != 0) {
        if(!array_key_exists('key', $_GET) || strcmp($note->key, $_GET['key']) != 0) {
            die('Bad key.');
        }
    }

    $contentsFileName = '../' . $NOTES_DIR . strval($id) . '_' . $note->revision . ".txt";
    $contents = file_get_contents($contentsFileName);

    echo $contents;

?>

</body>
</html>

