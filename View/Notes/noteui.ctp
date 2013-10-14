<?php
//	echo $this->Html->css('datepicker', null, array('inline' => false));
	echo $this->Html->script('note', array('charset'=>'UTF-8'));
?>

<div id="main" style="height:800px">

	<button id="addButton" type="button" class="btn btn-success col-sm-2">
		New Item
	</button>
	<div class="clearfix"></div><br />
	
	<div class="notes col-sm-10">
		
        <?php foreach($notes as $note) : ?>
        	
        <?php
        	echo $this->element('../Notes/note_element', array('note'=>$note));
        ?>

		<?php endforeach; ?>
		
    </div>
</div>

<div class="clearfix"></div>
<hr />
<br />
<br />
<div id="mydebug" class="col-sm-9 alert alert-success"></div>

<div id="delete-confirm" title="Delete Item?">本当に削除しますか？</div>
<div id="history-confirm" title="Delete Item?">完了したTodoを履歴に移動しますか？</div>


<div id="dialog-newnote" title="New note">
	<p class="validateTips">新しいノートを追加</p>

	<label for="name">Title</label><br />
	<input type="text" name="name" id="note_title" class="text ui-widget-content ui-corner-all" /><br />
	<label for="text">Note</label><br />
	<textarea name="text" id="note_text" rows="4" cols="25" class="text ui-widget-content ui-corner-all"></textarea>

</div>