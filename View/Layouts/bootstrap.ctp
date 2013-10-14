<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		<?php echo __('CakePHP: Todo:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php echo $this->Html->meta('icon'); ?>
	<!-- Le styles -->
	<?php echo $this->Html->css('bootstrap.min'); ?>
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/themes/redmond/jquery-ui.css" type="text/css" media="all" />
<!--
	<style>
	body {padding-top: 60px;}
	</style>
-->
	<?php echo $this->Html->css('main'); ?>

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<?php // echo $this->Html->script('vendor/html5shiv'); ?>
	<![endif]-->

	<?php
	echo $this->fetch('meta');
	echo $this->fetch('css');
	?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<!--    <?php // echo $this->Html->script('vendor/jquery-1.9.1.min'); ?>-->
    <?php echo $this->Html->script('vendor/bootstrap.min'); ?>
    <?php echo $this->Html->script('main'); ?>
    <?php echo $this->fetch('script'); ?>

</head>

<body>

    <?php echo $this->element('menu'); ?>
    
	<div class="container col-sm-8">

<!-- 		<h1>Bootstrap starter template</h1> -->

		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>

	</div> <!-- /container -->

	<div id="footer" class="col-sm-8">
		<?php echo $this->Html->link(
				$this->Html->image('cake.power.gif', array('alt' => '', 'border' => '0')),
				'http://www.cakephp.org/',
				array('target' => '_blank', 'escape' => false)
			);
		?>
		</div>

	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

</body>
</html>
