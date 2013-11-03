<div class="actions">
	<ul class="nav nav-pills well well-sm">
		<li><?php echo $this->Html->link(__('New Calendar'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="calendars index">
	<h2><?php echo __('Calendars'); ?></h2>

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
			<th><?php echo $this->Paginator->sort('position'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
		</tr>
	<?php foreach ($calendars as $calendar): ?>
	<tr style="white-space: nowrap;">
		<td class="actions">
			<?php echo $this->Icon->link(__('View'), array('action' => 'view', $calendar['Calendar']['id'])); ?>
			<?php echo $this->Icon->link(__('Edit'), array('action' => 'edit', $calendar['Calendar']['id'])); ?>
			<?php echo $this->Icon->postLink(__('Delete'), array('action' => 'delete', $calendar['Calendar']['id']), null, __('Are you sure you want to delete # %s?', $calendar['Calendar']['id'])); ?>
		</td>
		<td><?php echo h($calendar['Calendar']['id']); ?>&nbsp;</td>
		<td><?php echo h($calendar['Calendar']['name']); ?>&nbsp;</td>
		<td><?php echo h($calendar['Calendar']['position']); ?>&nbsp;</td>
		<td><?php echo h($calendar['Calendar']['created']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
