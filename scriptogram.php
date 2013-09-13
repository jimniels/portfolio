<?php
function get_scriptogram_JSON() {
    $username = 'jimniels';
    $url = 'http://scriptogr.am/'. $username .'/feed/';
    $fileContents = file_get_contents($url);

    $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
    $fileContents = trim(str_replace('"', "'", $fileContents));


    $simpleXml = simplexml_load_string($fileContents);

    echo $simpleXml;
    $json = json_encode($simpleXml);
    return $json;
}

echo get_scriptogram_JSON();