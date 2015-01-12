<div class="panel panel-inverse">

    <div class="panel-heading">
        <h3 class="panel-title">Directory</h2>
    </div>

    <div class="panel-body">
        <form id="opmitize-form" class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <fieldset>

            <div class="form-group hided">
                <label class="col-md-3 control-label">Directory</label>
                <select name="opmitize-directory" class="form-control">
                    <?php
                    $image_directory = 'images-to-optimize';
                    if ( $handle = opendir( $image_directory ) ) {
                        while ( false !== ( $entry = readdir( $handle ) ) ) {
                            if ( $entry != "." && $entry != ".." ) { ?>
                                <option value="<?php print $entry; ?>"><?php print $entry; ?></option>
                            <?php }
                        }
                        closedir($handle);
                    }

                    ?>
                </select>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">Directory</label>
                <div class="col-md-9 btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="opmitize-directory-label">Select a directory</span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <?php

                        if ( $handle = opendir( $image_directory ) ) {
                            while ( false !== ( $entry = readdir( $handle ) ) ) {
                                if ( $entry != "." && $entry != ".." ) { ?>
                                    <li><a href="#" id="dir-<?php print $entry; ?>" class="dir-select prevented"><?php print $entry; ?></a></li>
                                <?php }
                            }
                            closedir($handle);
                        }

                        ?>
                    </ul>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-9">
                    <button type="submit" class="btn btn-default btn-submit">Opmitize</button>
                </div>
            </div>
        </form> 

        </div><!-- table-of-images -->
    </div>