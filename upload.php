<?php
$data = array();

//check if this is an ajax request
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
    die();
}

if( isset($_GET['files']) ) {  
    $error = false;
    $files = array();

    $uploaddir = 'images-to-optimize/';
	foreach($_FILES as $file) {
        if( move_uploaded_file( $file['tmp_name'], $uploaddir . basename( $file['name'] ) ) ) {
            $files[] = $uploaddir . $file['name'];
            $nice_name = pathinfo( basename( $file['name'] ) );
            $zip = new ZipArchive;  
            if ( $zip->open( $uploaddir . $file['name'] ) === TRUE ) {
                $zip->extractTo( $uploaddir . $nice_name['filename'] );
                $zip->close();

                unlink( $uploaddir . $file['name'] );
            }
        }
        else{
            $error = true;
        }
    }
    $data = ($error) ? array('error' => 'There was an error uploading your files ' . $file['name'] . ', in folder: ' . $uploaddir) : array('files' => $files);
}
else {
    $data = array('success' => 'Form was submitted', 'formData' => $_POST);
}

echo json_encode($data);
?>