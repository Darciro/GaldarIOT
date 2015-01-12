<?php 
require_once('header.php');
require_once('sidebar.php'); 
?>

<div id="content" class="content">
	<?php 
	require_once('breadcrumb.php');
	if ( $_SERVER["REQUEST_METHOD"] == "POST" && !empty( $_POST['opmitize-directory'] ) ): ?>

		<h2 class="page-header">/<?php echo $_POST['opmitize-directory']; ?><small> directory selected</small></h2>

	<?php else:  ?>

		<h2 class="page-header">Select a directory <small>then click on "Opmitize" Button</small></h2>

	<?php 
	require_once('form.php'); 
	endif; 

	require_once('the-table.php'); ?>

    <div class="clearfix"></div>
</div><!-- /#content -->

<?php require_once('footer.php'); ?>