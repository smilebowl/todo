<?php
	echo $this->Html->css('/js/vendor/fullcalendar/fullcalendar.css', null, array('inline' => false));
	echo $this->Html->script('vendor/fullcalendar/fullcalendar.min.js', array('charset'=>'UTF-8'));
	echo $this->Html->script('vendor/fullcalendar/gcal.js', array('charset'=>'UTF-8'));
	echo $this->Html->script('event', array('charset'=>'UTF-8'));
?>

<div id="calendar" style="height:700px">



</div>

<div class="clearfix"></div>
<hr />
<!--<div id="mydebug" class="col-sm-9 alert alert-success"></div>-->

<div id="delete-confirm" title="Delete Item?">本当に削除しますか？</div>
<div id="dialog-event" title="Event" style="display: none;">
	<p>イベントを追加</p>

	<label for="name">タイトル</label><br />
	<input type="text" name="name" id="event_title" class="text ui-widget-content ui-corner-all" value="New event" /><br />
	<label for="name">日付</label><br />
	<input type="text" name="name" id="event_date" class="text ui-widget-content ui-corner-all" value="date" /><br />
</div>