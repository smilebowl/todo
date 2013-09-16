<li id="<?php echo $todo['Todo']['id']; ?>" class="todo">

	<div class="text"><?php echo $todo['Todo']['name']; ?></div>
	
	<div class="actions">
		<a href="#" class="edit">
			<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>
		</a>
		<a href="#" class="delete">
			<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></button>
		</a>
	</div>
	
</li>