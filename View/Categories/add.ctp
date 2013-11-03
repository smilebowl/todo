<div class="actions">
	<ul class="nav nav-pills well well-sm">

		<li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Notes'), array('controller' => 'notes', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="categories form">
<?php echo $this->Form->create('Category', array(
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
		<legend><?php echo __('Add Category'); ?></legend>
	<?php
		echo $this->Form->input('name', array('afterInput'=>'<span class="help-block"><span class="label label-warning">'.__('Required').'</span></span>'));
		echo $this->Form->input('position', array('afterInput'=>'<span class="help-block"><span class="label label-warning">'.__('Required').'</span></span>'));
	?>
	</fieldset>
<?php echo $this->Form->submit(__('Submit'), array('class'=>'btn btn-primary')); ?>
<?php echo $this->Form->end(); ?>
</div>
