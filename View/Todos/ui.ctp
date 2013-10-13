<div id="main">

	<button id="addButton" type="button" class="btn btn-success col-sm-1">
		Add
	</button>
	<div class="clearfix"></div><br />
	
	<div class="items col-sm-8">
		
        <?php foreach($todos as $todo) : ?>
        	
        <?php
        	echo $this->element('../Todos/todo_element', array('todo'=>$todo));
        ?>

		<?php endforeach; ?>
		
    </div>
</div>

<div class="clearfix"><br />
<div id="mydebug" class="col-sm-9 alert alert-success"></div>

<div id="delete-confirm" title="Delete Item?" style="dispay:none;">本当に削除しますか？</div>
