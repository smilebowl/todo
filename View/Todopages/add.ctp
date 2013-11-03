<div class="actions">
	<ul class="nav nav-pills well well-sm">

		<li><?php echo $this->Html->link(__('List Todopages'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Todos'), array('controller' => 'todos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Todo'), array('controller' => 'todos', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="todopages form">
<?php echo $this->Form->create('Todopage', array(
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
		<legend><?php echo __('Add Todopage'); ?></legend>
	<?php
		echo $this->Form->input('name', array('afterInput'=>'<span class="help-block"><span class="label label-warning">'.__('Required').'</span></span>'));
		echo $this->Form->input('ord', array('value'=>10,'afterInput'=>'<span class="help-block"><span class="label label-warning">'.__('Required').'</span></span>'));
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>
</div>
