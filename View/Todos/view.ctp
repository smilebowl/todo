<div class="actions">
	<ul class="nav nav-pills well well-sm">
		<li><?php echo $this->Html->link(__('Edit Todo'), array('action' => 'edit', $todo['Todo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Todo'), array('action' => 'delete', $todo['Todo']['id']), null, __('Are you sure you want to delete # %s?', $todo['Todo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Todos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Todopages'), array('controller' => 'todopages', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="todos view well">
<h2><?php  echo __('Todo'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($todo['Todo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Todopage'); ?></dt>
		<dd>
			<?php echo $this->Html->link($todo['Todopage']['name'], array('controller' => 'todopages', 'action' => 'view', $todo['Todopage']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Position'); ?></dt>
		<dd>
			<?php echo h($todo['Todo']['position']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($todo['Todo']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($todo['Todo']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Completed'); ?></dt>
		<dd>
			<?php echo h($todo['Todo']['completed']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
