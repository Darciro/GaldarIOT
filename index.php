<?php 
require_once('functions.php');
require_once('header.php'); ?>

    <?php require_once('sidebar.php'); ?>

    <div id="content" class="content">

        <div class="col-md-7">
            <div class="panel panel-inverse">

                <?php
                    $i = 0;
                    $galdariot_files_size = 0;
                    $galdariot_count_images = 0;
                    $galdariot_count_files = 0;
                    $images_to_optimize_dir = OPT_DIR;
                    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($images_to_optimize_dir)) as $file){
                        $galdariot_files_size+=$file->getSize();
                        $galdariot_count_files++;
                        if( $file->getBasename() !== '.' && $file->getBasename() !== '..' && !$file->isDir() ){
                            $galdariot_count_images++;
                        }
                    }

                    $dir = 'images-to-optimize/';
                    if ( $handle = opendir( $dir ) ) {
                        while ( false !== ( $entry = readdir( $handle ) ) ) {
                            if ( $entry != '.' && $entry != '..' ){
                                $i++;
                            }
                        }
                        closedir($handle);
                    }
                ?>

                <div class="panel-heading">
                    <h3 class="panel-title">Directories Found</h2>
                </div>
                <div class="panel-body">
                    <div class="chart-wrapper">
                        <!-- <div class="chart-title">
                            <p><?php // echo $i; ?> Directories Found</p>
                        </div> -->
                        <div class="chart-stage">
                            <div id="grid-1-1">
                                <canvas id="galdariot-chart" width="538" height="420"></canvas>
                            </div>
                        </div>
                        <div class="chart-notes">
                            <p><?php echo $i; ?> Directories Found</p>
                        </div>
                      </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">

            <div class="widget widget-stats">
                <div class="stats-icon">
                    <!-- <span class="glyphicon glyphicon-stats" aria-hidden="true"></span> -->
                    <i class="fa fa-area-chart"></i>
                </div>
                <div class="stats-info">
                    <h4>Total size</h4>
                    <p><?php echo formatedSize($galdariot_files_size); ?></p>    
                </div>
                <!-- <div class="stats-link">
                    <a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
                </div> -->
            </div>

            <div class="widget widget-images">
                <div class="stats-icon">
                    <!-- <span class="glyphicon glyphicon-picture" aria-hidden="true"></span> -->
                    <i class="fa fa-camera-retro"></i>
                </div>
                <div class="stats-info">
                    <h4>Images to optimize</h4>
                    <p><?php echo $galdariot_count_images; ?></p>    
                </div>
                <!-- <div class="stats-link">
                    <a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
                </div> -->
            </div>

            <div class="widget widget-files">
                <div class="stats-icon">
                    <span class="glyphicon glyphicon-inbox" aria-hidden="true"></span>
                </div>
                <div class="stats-info">
                    <h4>All files</h4>
                    <p><?php echo $galdariot_count_files; ?></p>    
                </div>
                <!-- <div class="stats-link">
                    <a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
                </div> -->
            </div>

            <div class="widget widget-upload">
                <div class="stats-icon">
                    <!-- <span class="glyphicon glyphicon-import" aria-hidden="true"></span> -->
                    <i class="fa fa-upload"></i>
                </div>
                <div class="stats-info">
                    <h4>Upload Folder</h4>
                    <form id="upload-form" name="upload-form" action="upload.php" method="post">
                        <input id="upload-folder-input" name="fileToUpload" type="file" class="filestyle" data-input="false" data-buttonText="Choose folder" data-size="sm">
                        <button type="submit" class="btn btn-default btn-sm btn-upload">Ok</button>
                    </form>
                </div>
                <!-- <div class="stats-link">
                    <a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
                </div> -->
            </div>

        </div>

        <div class="clearfix"></div>
    </div><!-- /#content -->

<?php require_once('footer.php'); ?>