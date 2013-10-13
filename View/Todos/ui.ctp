<div id="main">

	<button id="addButton" type="button" class="btn btn-success col-sm-1">
		Add
	</button>
	<button id="historyButton" type="button" class="btn btn-warning col-sm-3">
		Completed to history
	</button>
	<div class="clearfix"></div><br />
	
	<div class="items col-sm-10">
		
        <?php foreach($todos as $todo) : ?>
        	
        <?php
        	echo $this->element('../Todos/todo_element', array('todo'=>$todo));
        ?>

		<?php endforeach; ?>
		
    </div>
</div>

<div class="clearfix"><br />
<div id="mydebug" class="col-sm-9 alert alert-success"></div>

<div id="delete-confirm" title="Delete Item?">本当に削除しますか？</div>
