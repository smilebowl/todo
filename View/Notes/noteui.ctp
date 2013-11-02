<?php
//	echo $this->Html->css('datepicker', null, array('inline' => false));
	echo $this->Html->script('note', array('charset'=>'UTF-8'));
?>

<?php $category_id = empty($this->request->data['category_id'])  ? key($categories) : $this->request->data['category_id']; ?>
<form id="NoteNoteuiForm" method="post" accept-charset="utf-8">
	<input type="hidden" name="category_id" id="NoteCategoryId" value="<?php echo $category_id; ?>">
</form>

<ul class="nav nav-tabs">
	<?php foreach ($categories as $idx =>$category) : ?>
	  <li class="<?php echo ($category_id==$idx)?'active':''; ?>">
		<a href="#" class="categoryid" id="cid_<?php echo $idx; ?>"><?php echo $category;?></a>
	  </li>
	<?php endforeach; ?>
</ul>
<br />

<div id="notepage" style="height:800px">

	<?php
		//echo $this->Form->create('Note');
		//echo $this->Form->input('category_id', array('label'=>false, 'class'=>'form-control', 'div'=>false));
		//echo $this->Form->end();
	?>
		
	<button id="addButton" type="button" class="btn btn-success col-sm-2">
		New Item
	</button>
	<div class="clearfix"></div>
	
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
<!--<div id="mydebug" class="col-sm-9 alert alert-success"></div>-->

<div id="delete-confirm" title="Delete Item?">本当に削除しますか？</div>


<div id="dialog-newnote" title="New note">
	<p>新しいノートを追加</p>

	<label for="name">Title</label><br />
	<input type="text" name="name" id="note_title" class="form-control" value="New note" /><br />
	<label for="text">Note</label><br />
	<textarea name="text" id="note_text" rows="4" cols="25" class="form-control">note.</textarea>

</div>
<div id="dialog-title" title="Title">
	<p>タイトルを変更</p>

<!--	<label for="name">Title</label><br />-->
	<input type="text" name="name" id="note_newtitle" class="form-control" value="New title" /><br />
</div>