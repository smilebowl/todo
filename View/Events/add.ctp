<div class="actions">
	<ul class="nav nav-pills well well-sm">

		<li><?php echo $this->Html->link(__('List Events'), array('action' => 'index')); ?></li>
	</ul>
</div>
<div class="events form">
<?php echo $this->Form->create('Event', array(
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
		<legend><?php echo __('Add Event'); ?></legend>
	<?php
		echo $this->Form->input('title', array('afterInput'=>'<span class="help-block"><span class="label label-warning">'.__('Required').'</span></span>'));
		echo $this->Form->input('start', array('afterInput'=>'<span class="help-block"><span class="label label-warning">'.__('Required').'</span></span>'));
		echo $this->Form->input('end');
		echo $this->Form->input('color');
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>
</div>
