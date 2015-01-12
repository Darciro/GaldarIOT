<ol class="breadcrumb pull-right">
    <li>
        <a href="<?php echo dirname($_SERVER['PHP_SELF']); ?>/">Home</a>
    </li>
    <li>
        <a href="<?php echo dirname($_SERVER['PHP_SELF']) . '/' . basename($_SERVER['PHP_SELF']); ?>">Optimizer</a>
    </li>

    <?php if ( $_SERVER["REQUEST_METHOD"] == "POST" && !empty( $_POST['opmitize-directory'] ) ): ?>

        <li class="active"><?php echo $_POST['opmitize-directory']; ?></li>

    <?php elseif( basename($_SERVER['PHP_SELF']) == 'how-to.php' ): ?>

        <li class="active">How to use</li>

    <?php elseif( basename($_SERVER['PHP_SELF']) == 'about-me.php' ): ?>

        <li class="active">About me</li>

    <?php elseif( basename($_SERVER['PHP_SELF']) == 'about-the-tool.php' ): ?>

        <li class="active">The tool</li>    

    <?php else: ?>

        <li class="active">Select a directory</li>

    <?php endif; ?>

</ol>