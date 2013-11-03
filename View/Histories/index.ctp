<div class="actions">
	<ul class="nav nav-pills well well-sm">
		<li><?php echo $this->Form->postLink(__('DeleteAll'), array('action' => 'deleteall'), null, __('Are you sure you want to delete all?')); ?></li>
	</ul>
</div>
<div class="histories index">
	<h2><?php echo __('Histories'); ?></h2>

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
			<th><?php echo $this->Paginator->sort('completed'); ?></th>
		</tr>
	<?php foreach ($histories as $history): ?>
	<tr style="white-space: nowrap;">
		<td class="actions">
			<?php echo $this->Icon->link(__('View'), array('action' => 'view', $history['History']['id'])); ?>
			<?php echo $this->Icon->link(__('Edit'), array('action' => 'edit', $history['History']['id'])); ?>
			<?php echo $this->Icon->postLink(__('Delete'), array('action' => 'delete', $history['History']['id']), null, __('Are you sure you want to delete # %s?', $history['History']['id'])); ?>
		</td>
		<td><?php echo h($history['History']['id']); ?>&nbsp;</td>
		<td><?php echo h($history['History']['position']); ?>&nbsp;</td>
		<td><?php echo h($history['History']['name']); ?>&nbsp;</td>
		<td><?php echo h($history['History']['created']); ?>&nbsp;</td>
		<td><?php echo h($history['History']['completed']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
