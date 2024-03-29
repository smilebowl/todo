<?php
	if ($todo['Todo']['completed']) {
		$completed = ' completed';
		$dishistory = '';
	} else {
		$completed = '';
		$dishistory = 'disabled="disabled"';
	}
	$emphasis = $todo['Todo']['emphasis'] ? ' text-danger' : '';
?>


<div id="<?php echo $todo['Todo']['id']; ?>" class="item<?php echo $completed; ?>">

	<a href "#" class="edititem">
		<button type="button" class="btn btn-primary btn-xs">
			<span class="glyphicon glyphicon-pencil"></span>
		</button>
	</a>
	<a href "#" class="compitem">
		<button type="button" class="btn btn-success btn-xs">
			<span class="glyphicon glyphicon-saved"></span>
		</button>
	</a>
	<a href "#" class="tohistory">
		<button type="button" class="btn btn-info btn-xs" <?php echo $dishistory; ?>>
			<span class="glyphicon glyphicon-export"></span>
		</button>
	</a>
	<a href "#" class="removeitem">
		<button type="button" class="btn btn-warning btn-xs">
			<span class="glyphicon glyphicon-remove"></span>
		</button>
	</a>
	<input type="checkbox" name="check[]" value="<?php echo $todo['Todo']['id'];?>" />
	
	<span class="date-created"><?php echo substr($todo['Todo']['created'],5,5); ?></span>
	<span class="date-completed"><?php echo substr($todo['Todo']['completed'],5,5); ?></span>
	<span class="itemtext<?php echo $emphasis;?>"><?php echo $todo['Todo']['name']; ?></span>
	
</div>