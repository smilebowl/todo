<div class="actions">
	<ul class="nav nav-pills well well-sm">
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('History.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('History.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Histories'), array('action' => 'index')); ?></li>
	</ul>
</div>
<div class="histories form">
<?php echo $this->Form->create('History', array(
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
		<legend><?php echo __('Edit History'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('position');
		echo $this->Form->input('name');
		echo $this->Form->input('completed', array('type'=>'text', 'class'=>'form-control dateEditable'));
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>
</div>
