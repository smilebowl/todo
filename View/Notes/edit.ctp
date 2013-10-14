<div class="actions">
	<ul class="nav nav-pills well well-sm">

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Note.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Note.id'))); ?></li>
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
		<legend><?php echo __('Edit Note'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('position');
		echo $this->Form->input('name');
		echo $this->Form->input('text');
		echo $this->Form->input('xyzhw');
		echo $this->Form->input('color');
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>
</div>
