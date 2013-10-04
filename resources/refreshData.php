<?php
function getScriptogramJSON() {
    $username = 'jimniels';
    $url = 'http://scriptogr.am/'. $username .'/feed/';
    $fileContents = file_get_contents($url);

    $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
    $fileContents = trim(str_replace('"', "'", $fileContents));


    $simpleXml = simplexml_load_string($fileContents);

    $json = json_encode($simpleXml);
    return $json;
}

// verify the data
$data = json_decode(getScriptogramJSON(), true);

// write the data to cache file
if ( $data['channel']['item'][0]['title'] != '' || $data['channel']['item'][0]['title'] != null) {
    
    $file = dirname(__FILE__) . '/json/scriptogram.json';

    if ( file_exists($file) ) {
        $f = file_put_contents($file, json_encode($data) );
        if($f) {
            echo 'File written! <br>';
            echo json_encode($data);
        }
    } else {
        echo 'file does not exists';
    }
}