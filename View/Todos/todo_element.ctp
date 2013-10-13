<div id="<?php echo $todo['Todo']['id']; ?>" class="item">

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
	<a href "#" class="removeitem">
		<button type="button" class="btn btn-warning btn-xs">
			<span class="glyphicon glyphicon-remove"></span>
		</button>
	</a>
	
	<span class="itemtext"><?php echo $todo['Todo']['name']; ?></span>
	
</div>