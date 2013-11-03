<div class="actions">
	<ul class="nav nav-pills well well-sm">
		<li><?php echo $this->Html->link(__('Edit Calendar'), array('action' => 'edit', $calendar['Calendar']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Calendar'), array('action' => 'delete', $calendar['Calendar']['id']), null, __('Are you sure you want to delete # %s?', $calendar['Calendar']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendars'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="calendars view well">
<h2><?php  echo __('Calendar'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($calendar['Calendar']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($calendar['Calendar']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Position'); ?></dt>
		<dd>
			<?php echo h($calendar['Calendar']['position']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($calendar['Calendar']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php echo __('Related Events'); ?></h3>
	<?php if (!empty($calendar['Event'])): ?>
	<table class="table table-striped table-hover table-condensed">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Start'); ?></th>
		<th><?php echo __('End'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($calendar['Event'] as $event): ?>
		<tr>
			<td><?php echo $event['id']; ?></td>
			<td><?php echo $event['title']; ?></td>
			<td><?php echo $event['start']; ?></td>
			<td><?php echo $event['end']; ?></td>
			<td><?php echo $event['created']; ?></td>
			<td class="actions">
				<?php echo $this->Icon->link(__('View'), array('controller' => 'events', 'action' => 'view', $event['id'])); ?>
				<?php echo $this->Icon->link(__('Edit'), array('controller' => 'events', 'action' => 'edit', $event['id'])); ?>
				<?php echo $this->Icon->postLink(__('Delete'), array('controller' => 'events', 'action' => 'delete', $event['id']), null, __('Are you sure you want to delete # %s?', $event['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>


</div>
