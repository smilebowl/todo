<div class="actions">
	<ul class="nav nav-pills well well-sm">
		<li><?php echo $this->Html->link(__('Edit History'), array('action' => 'edit', $history['History']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete History'), array('action' => 'delete', $history['History']['id']), null, __('Are you sure you want to delete # %s?', $history['History']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Histories'), array('action' => 'index')); ?> </li>
	</ul>
</div>
<div class="histories view well">
<h2><?php  echo __('History'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($history['History']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Position'); ?></dt>
		<dd>
			<?php echo h($history['History']['position']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($history['History']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($history['History']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Completed'); ?></dt>
		<dd>
			<?php echo h($history['History']['completed']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
