<?php 
// header('Content-Type: application/json');
require_once('functions.php');
$dir = OPT_DIR;
// $outp = [];
$outp = array();

function CalcDirectorySize($DirectoryPath) {
    $Size = 0;
    $Dir = opendir($DirectoryPath);
 
    if (!$Dir)
        return -1;
 
    while (($File = readdir($Dir)) !== false) {
 
        // Skip file pointers
        if ($File[0] == '.') continue; 
 
        // Go recursive down, or add the file size
        if (is_dir($DirectoryPath . $File))            
            $Size += CalcDirectorySize($DirectoryPath . $File . DIRECTORY_SEPARATOR);
        else 
            $Size += filesize($DirectoryPath . $File);        
    }
 
    closedir($Dir);
 
    return $Size;
}

function rand_color() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}


if ( $handle = opendir( $dir ) ) {
    while ( false !== ( $entry = readdir( $handle ) ) ) {
        if ( $entry != '.' && $entry != '..' ){

            $fi = iterator_count(new FilesystemIterator('images-to-optimize' . '/' . $entry, FilesystemIterator::SKIP_DOTS));
            // printf("There were %d Files", iterator_count($fi));
            // echo $fi;

            $size = CalcDirectorySize( $dir . $entry . '/');
            $tmp = array();
            $tmp["value"] = intval( $fi );
            $tmp["color"] = rand_color();
            $tmp["highlight"] = rand_color();
            $tmp["label"] = $entry . ' ('.formatedSize($size) . '), Files';

            $outp[] = $tmp;
        }
    }
    closedir($handle);
}

echo json_encode($outp);