<div class="actions">
	<ul class="nav nav-pills well well-sm">
		<li><?php echo $this->Html->link(__('New Todo'), array('action' => 'add')); ?></li>
	</ul>
</div>
<div class="todos index">
	<h2><?php echo __('Todos'); ?></h2>

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
			<th><?php echo $this->Paginator->sort('position'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('deleted'); ?></th>
			<th><?php echo $this->Paginator->sort('deleted_date'); ?></th>
		</tr>
	<?php foreach ($todos as $todo): ?>
	<tr style="white-space: nowrap;">
		<td class="actions">
			<?php echo $this->Icon->link(__('View'), array('action' => 'view', $todo['Todo']['id'])); ?>
			<?php echo $this->Icon->link(__('Edit'), array('action' => 'edit', $todo['Todo']['id'])); ?>
			<?php echo $this->Icon->postLink(__('Delete'), array('action' => 'delete', $todo['Todo']['id']), null, __('Are you sure you want to delete # %s?', $todo['Todo']['id'])); ?>
		</td>
		<td><?php echo h($todo['Todo']['id']); ?>&nbsp;</td>
		<td><?php echo h($todo['Todo']['position']); ?>&nbsp;</td>
		<td><?php echo h($todo['Todo']['name']); ?>&nbsp;</td>
		<td><?php echo h($todo['Todo']['created']); ?>&nbsp;</td>
		<td><?php echo h($todo['Todo']['modified']); ?>&nbsp;</td>
		<td><?php echo h($todo['Todo']['deleted']); ?>&nbsp;</td>
		<td><?php echo h($todo['Todo']['deleted_date']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
