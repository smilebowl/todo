<div class="actions">
	<ul class="nav nav-pills well well-sm">
		<li><?php echo $this->Html->link(__('New Event'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Calendars'), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
	</ul>
</div>

<div class="events index">
	<h2><?php echo __('Events'); ?></h2>

<?php echo $this->Form->create('Event', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => false,
		'wrapInput' => false,
		'class' => 'form-control'
	),
	'class' => 'form-inline well well-sm',
	'novalidate' => true
	)); 
	echo $this->Form->submit('Search', array(
		'div' => 'form-group',
		'class' => 'btn btn-primary'
	));
	echo $this->Form->input('calendar_id', array('empty'=>'---'));
	echo $this->Form->input('start', array(
		'type'=>'text','class'=>'form-control col col-sm-1 dateEditable','placeholder' => 'start day'
	));
	echo $this->Form->input('keyword', array(
		'type'=>'text','class'=>'form-control','placeholder' => 'keyword'
	));
	echo $this->Form->end();
?>

<div class="clearfix"></div>


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
			<th><?php echo $this->Paginator->sort('calendar_id'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('start'); ?></th>
			<th><?php echo $this->Paginator->sort('end'); ?></th>
			<th><?php echo $this->Paginator->sort('detail'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
		</tr>
	<?php foreach ($events as $event): ?>
	<tr style="white-space: nowrap;">
		<td class="actions">
			<?php echo $this->Icon->link(__('View'), array('action' => 'view', $event['Event']['id'])); ?>
			<?php echo $this->Icon->link(__('Edit'), array('action' => 'edit', $event['Event']['id'])); ?>
			<?php echo $this->Icon->postLink(__('Delete'), array('action' => 'delete', $event['Event']['id']), null, __('Are you sure you want to delete # %s?', $event['Event']['id'])); ?>
		</td>
		<td><?php echo h($event['Event']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($event['Calendar']['name'], array('controller' => 'calendars', 'action' => 'view', $event['Calendar']['id'])); ?>
		</td>
		<td><?php echo h($event['Event']['title']); ?>&nbsp;</td>
		<td><?php echo h($event['Event']['start']); ?>&nbsp;</td>
		<td><?php echo h($event['Event']['end']); ?>&nbsp;</td>
		<td><?php echo String::truncate(h($event['Event']['detail']),25); ?>&nbsp;</td>
		<td><?php echo h($event['Event']['created']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
