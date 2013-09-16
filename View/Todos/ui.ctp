<div id="main">

	<button id="addButton" type="button" class="btn btn-success col-sm-1">
		Add
	</button>

	<ul class="todoList col-sm-8">
		
        <?php foreach($todos as $todo) : ?>
        	
        <?php
        	echo $this->element('../Todos/todo_element', array('todo'=>$todo));
        ?>

		<?php endforeach; ?>
		
    </ul>



</div>

<div id="dialog-confirm" title="Delete TODO Item?">Are you sure you want to delete this TODO item?</div>