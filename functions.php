<?php
// Constants
define("OPT_DIR", $_SERVER['DOCUMENT_ROOT'] . '/projects/' . basename(__DIR__) . '/images-to-optimize/');

// Show errors
/*ini_set('display_errors', 1);
error_reporting(E_ALL);*/

// Convert file size to a human readable format
function formatedSize($size){
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
};