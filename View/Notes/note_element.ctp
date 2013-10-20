<?php
	$xyz = explode('.',$note['Note']['xyz']);
	$wh = explode('.',$note['Note']['wh']);
	$style = "left:{$xyz[0]}px; top:{$xyz[1]}px; z-index:{$xyz[2]}; width:{$wh[0]}px; height:{$wh[1]}px; ";
?>

<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ui-draggable ui-resizable" id="<?php echo $note['Note']['id']; ?>" style="<?php echo $style;?>">
	<div class="portlet-header ui-widget-header ui-corner-all">
		<span class="ui-icon ui-icon-close"></span>
		<span class="ui-icon ui-icon-pause"></span>
		<?php echo $note['Note']['name']; ?>
	</div>
	<div class="portlet-content" contenteditable="true"><?php echo $note['Note']['text']; ?></div>
	<div class="ui-resizable-handle ui-resizable-e"></div>
	<div class="ui-resizable-handle ui-resizable-s"></div>
	<div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se"></div>	
</div>
