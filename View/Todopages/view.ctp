<div class="actions">
	<ul class="nav nav-pills well well-sm">
		<li><?php echo $this->Html->link(__('Edit Todopage'), array('action' => 'edit', $todopage['Todopage']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Todopage'), array('action' => 'delete', $todopage['Todopage']['id']), null, __('Are you sure you want to delete # %s?', $todopage['Todopage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Todopages'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Todopage'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Todos'), array('controller' => 'todos', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="todopages view well">
<h2><?php  echo __('Todopage'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($todopage['Todopage']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($todopage['Todopage']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ord'); ?></dt>
		<dd>
			<?php echo h($todopage['Todopage']['ord']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($todopage['Todopage']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php echo __('Related Todos'); ?></h3>
	<?php if (!empty($todopage['Todo'])): ?>
	<table class="table table-striped table-hover table-condensed">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Completed'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($todopage['Todo'] as $todo): ?>
		<tr>
			<td><?php echo $todo['id']; ?></td>
			<td><?php echo $todo['name']; ?></td>
			<td><?php echo $todo['created']; ?></td>
			<td><?php echo $todo['completed']; ?></td>
			<td class="actions">
				<?php echo $this->Icon->link(__('View'), array('controller' => 'todos', 'action' => 'view', $todo['id'])); ?>
				<?php echo $this->Icon->link(__('Edit'), array('controller' => 'todos', 'action' => 'edit', $todo['id'])); ?>
				<?php echo $this->Icon->postLink(__('Delete'), array('controller' => 'todos', 'action' => 'delete', $todo['id']), null, __('Are you sure you want to delete # %s?', $todo['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>


</div>
