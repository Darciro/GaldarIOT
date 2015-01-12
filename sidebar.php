<div id="sidebar" class="sidebar">

    <ul class="nav">
        <li class="nav-header">
            <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a>
        </li>
        <li class="nav-header">
            <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/optimizer.php"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Optimizer</a>
        </li>
        <li class="nav-header">
            <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/how-to.php"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> How to use</a>
        </li>
        <li class="has-sub">
            <a class="sub-item prevented" href="#">
                <!-- <b class="caret pull-right"></b> -->
                <i class="fa fa-caret-down pull-right"></i>
                <i class="fa fa-caret-up pull-right"></i>

                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> About
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/about-me.php">Author</a>
                </li>
                <li>
                    <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/about-the-tool.php">The Tool</a>
                </li>
                <!-- <li class="active">
                    <a href="<?php // echo dirname($_SERVER['PHP_SELF']); ?>/system-info.php">System Info</a>
                </li> -->
            </ul>
        </li>
    </ul>

</div><!-- /#sidebar -->