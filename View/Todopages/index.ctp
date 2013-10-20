<div class="actions">
	<ul class="nav nav-pills well well-sm">
		<li><?php echo $this->Html->link(__('New Todopage'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Todos'), array('controller' => 'todos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Todo'), array('controller' => 'todos', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="todopages index">
	<h2><?php echo __('Todopages'); ?></h2>

	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<?php echo $this->Paginator->pagination(array('ul' => 'pagination', 'modulus'=>9)); ?>

	<table class="table table-striped table-hover table-condensed">
	<tr>
		<th class="actions"><?php echo __('Actions'); ?></th>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('ord'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
		</tr>
	<?php foreach ($todopages as $todopage): ?>
	<tr style="white-space: nowrap;">
		<td class="actions">
			<?php echo $this->Icon->link(__('View'), array('action' => 'view', $todopage['Todopage']['id'])); ?>
			<?php echo $this->Icon->link(__('Edit'), array('action' => 'edit', $todopage['Todopage']['id'])); ?>
			<?php echo $this->Icon->postLink(__('Delete'), array('action' => 'delete', $todopage['Todopage']['id']), null, __('Are you sure you want to delete # %s?', $todopage['Todopage']['id'])); ?>
		</td>
		<td><?php echo h($todopage['Todopage']['id']); ?>&nbsp;</td>
		<td><?php echo h($todopage['Todopage']['name']); ?>&nbsp;</td>
		<td><?php echo h($todopage['Todopage']['ord']); ?>&nbsp;</td>
		<td><?php echo h($todopage['Todopage']['created']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
