<?php
//	echo $this->Html->css('datepicker', null, array('inline' => false));
	echo $this->Html->script('todo', array('charset'=>'UTF-8'));
?>

<?php $todopage_id = empty($this->request->data['todopage_id'])  ? key($todopages) : $this->request->data['todopage_id']; ?>
<form id="TodoTodouiForm" method="post" accept-charset="utf-8">
	<input type="hidden" name="todopage_id" id="TodoTodopageId" value="<?php echo $todopage_id; ?>">
</form>

<ul class="nav nav-tabs">
	<?php foreach ($todopages as $idx =>$todopage) : ?>
	  <li class="<?php echo ($todopage_id==$idx)?'active':''; ?>">
		<a href="#" class="todopageid" id="cid_<?php echo $idx; ?>"><?php echo $todopage;?></a>
	  </li>
	<?php endforeach; ?>
</ul>
<br />

<div id="todopage">

	<?php
//		echo $this->Form->create('Todo');
//		echo $this->Form->input('todopage_id', array('label'=>false, 'class'=>'form-control', 'div'=>false));
//		echo $this->Form->end();
	?>

	<button id="addButton" type="button" class="btn btn-success col-sm-2">
		New Item
	</button>
	<button id="historyButton" type="button" class="btn btn-warning col-sm-3">
		Completed items to history
	</button>
	<button id="removeAllButton" type="button" class="btn btn-danger col-sm-3">
		Remove checked items
	</button>
	<div class="clearfix"></div><br />
	
	<div class="items col-sm-10 col-sm-offset-1">
		
        <?php foreach($todos as $todo) : ?>
        	
        <?php
        	echo $this->element('../Todos/todo_element', array('todo'=>$todo));
        ?>

		<?php endforeach; ?>
		
    </div>
</div>

<div class="clearfix"></div>
<br />
<div id="mydebug" class="col-sm-9 alert alert-success"></div>

<div id="delete-confirm" title="Delete Item?">本当に削除しますか？</div>
<div id="history-confirm" title="Delete Item?">完了したTodoを履歴に移動しますか？</div>
