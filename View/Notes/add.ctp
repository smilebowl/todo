<div class="actions">
	<ul class="nav nav-pills well well-sm">

		<li><?php echo $this->Html->link(__('List Notes'), array('action' => 'index')); ?></li>
	</ul>
</div>
<div class="notes form">
<?php echo $this->Form->create('Note', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-xs-2 control-label'),
		'wrapInput' => 'col col-xs-5',
		'class' => 'form-control'),
	'class' => 'well form-horizontal',
	'novalidate' => true
	)); ?>
	<fieldset>
		<legend><?php echo __('Add Note'); ?></legend>
	<?php
		echo $this->Form->input('position');
		echo $this->Form->input('name');
		echo $this->Form->input('text');
		echo $this->Form->input('xyz');
		echo $this->Form->input('wh');
		echo $this->Form->input('color');
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>
</div>
