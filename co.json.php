<?php

function getJsonElementById($list, $id) {
    foreach($list as $e) {
        if(intval($e->id) == intval($id)) {
            return $e;
        }
    }

    return NULL;
}

function readJson($fileName) {
    if(!file_exists($fileName)) {
        return null;
    }
    $jsontxt = file_get_contents($fileName);
    return json_decode($jsontxt);
}

function writeJson($fileName, $json) {
    $jsontxt = json_encode($json);
    file_put_contents ( $fileName, $jsontxt );
}

function sanitizeId($name) {
    return preg_replace("/[^a-zA-Z0-9]+/", "", $name);
}



?>
