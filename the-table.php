<?php
    require_once('functions.php');
    $dir = '';
    $some_error = false;
    if ( $_SERVER["REQUEST_METHOD"] == "POST" && !empty( $_POST['opmitize-directory'] ) ):

    $dir = OPT_DIR . $_POST["opmitize-directory"] . '/';

?>
    <div id="table-of-images" class="loading-list">
        <div class="loading panel panel-default">
            <div class="panel-heading">Processing.</div>
            <div class="panel-body">
                <p>Please wait while the images are being optimized...</p>
                <img src="assets/img/loading.gif" alt="" />
            </div>
        </div>
        <div class="loading-modal"></div>
        <table class="table table-hover" style="margin-top: 40px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image Name</th>
                    <th class="text-center">Format</th>
                    <th class="text-center">Original Size</th>
                    <th class="text-center">Optimized Size</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
        <?php

            // Initiate needed variables
            $i = 0;
            $total_images = 0;
            $size = 0;
            $optimized_size = 0;
            $all_files_size = 0;
            $all_files_size_optimized = 0;
            $not_supported_format = false;

            // Delete Temporary files
            /*function deleteTemporaryFiles($dir){
                foreach ( glob( $dir . '/thumbnail-imagick-*' ) as $temporary_file ) {
                    unlink( $temporary_file );
                }
            }*/

            /*function deleteTemporaryFiles($pattern, $flags = 0) {
                $files = glob($pattern, $flags); 
                foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
                    $files = array_merge($files, deleteTemporaryFiles($dir.'/'.basename($pattern), $flags));
                }
                return $files;
            }*/

            // Get the original Directory Size
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $file){
                $all_files_size+=$file->getSize();
            }

            // Convert file size to a human readable format
            /*function formatedSize($size){
                $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
                $power = $size > 0 ? floor(log($size, 1024)) : 0;
                return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
            }*/

            foreach( new RecursiveIteratorIterator( new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::SELF_FIRST ) as $key => $file):
                // $files[] = $file;
                //; $files[] = $file->getPathname();
                

                // $files = '';
                /*if ( $file->isDir() && $file->getBasename() !== '.' && $file->getBasename() !== '..' ) {
                    $breadcrumb[] = $file->getBasename();
                }*/
                /*echo "<pre>";
                var_dump( $breadcrumb );
                echo "</pre>";*/
                // Skip hidden files and directories
                if( $file->getBasename() !== '.' && $file->getBasename() !== '..' && !$file->isDir() ):
                    $i++;


                    // Get the size of each file
                    $size = $file->getSize();
                    $size = formatedSize($size);

                    // Optimizing the image
                    if( $file->getExtension() === 'png' || $file->getExtension() === 'jpg' ){
                        $im = new Imagick( $file->getPathname() );
                        $im->stripImage();
                        
                        $strip = $im->stripImage();
                        $quality = $im->setImageCompressionQuality(75);
                        $im->writeImage( $file->getPathname() );

                        // Get the optimized size
                        $data = $im->__toString();
                        $optimized_size = strlen($data);
                        $not_supported_format = false;

                        // Creates a Temporary Thumbnail
                        /*$im->thumbnailImage( 30, null, 0 );
                        $thumb = 'thumbnail-imagick-' . $file->getBasename();
                        $im->writeImage( $file->getPath() . '/' . $thumb );*/
                        
                        // $thumb_path = $_SERVER['HTTP_REFERER'] . $_POST["opmitize-directory"] . basename( dirname( $file->getPathname() ) ) . '/' . $thumb;
                        // $thumb_path = $_SERVER['HTTP_REFERER'] . ' + ' . basename( dirname( $file->getPathname() ) ); // . basename( dirname( $file->getPathname() ) );
                        // $thumb_path = $breadcrumb ? $breadcrumb : '';
                        // print_r( $thumb_path ) . "<br/>";
                        // Destroys Imagick object, freeing allocated resources in the process
                        $im->destroy();
                        $total_images++;
                    }else{
                        // If the file is not a supported image
                        $not_supported_format = true;
                    }

        ?>

                <tr <?php if ($not_supported_format){ echo 'class="alert alert-warning" title="Not Supported Format"'; } ?>>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $file->getBasename(); ?></td>
                    <td class="text-center"><?php echo $file->getExtension(); ?></td>
                    <td class="text-center"><?php echo $size; ?></td>
                    <td class="text-center">
                        <?php 
                            if ($not_supported_format){ 
                                echo $size; 
                            }else{ 
                                echo formatedSize($optimized_size); 
                            };
                        ?>
                    </td>
                    <td class="text-center">
                        <?php if ($not_supported_format): ?>
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        <?php else: ?>
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        <?php endif; ?>
                    </td>
                </tr>
                
        <?php   
                endif;
                // Skiped hidden files and directories
            endforeach;

            //Post process
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $file){
                // Get the Optimized Directory Size
                $all_files_size_optimized+=$file->getSize();

                // Delete Temporary files getPathname
                $subject = $file->getBasename();
                $pattern = '/thumbnail-imagick-/';
                if ( preg_match( $pattern, $subject ) ) {
                    unlink( $file->getPathname() );
                }
            }
            
        ?>             
            <tfoot>
                <tr>
                    <td colspan="6" class="text-right"><strong>Directory Initial Size: <?php echo formatedSize($all_files_size); ?></strong></td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right"><strong>Optimized Size: <?php echo formatedSize($all_files_size_optimized); ?></strong></td>
                </tr>
                <tr class="total-optimized">
                    <td colspan="6" class="text-right"><strong>Total of Images optimized: <?php echo $total_images; ?></strong></td>
                </tr>
            </tfoot>               
            </tbody>
        </table>
    <?php endif; ?>