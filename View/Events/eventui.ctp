<?php
	echo $this->Html->css('/js/vendor/fullcalendar/fullcalendar.css', null, array('inline' => false));
	echo $this->Html->css('/js/vendor/colorpicker/jquery.simplecolorpicker.css', null, array('inline' => false));
	echo $this->Html->css('/js/vendor/colorpicker/jquery.simplecolorpicker-glyphicons.css', null, array('inline' => false));
	
	echo $this->Html->script('vendor/fullcalendar/fullcalendar.min.js', array('charset'=>'UTF-8'));
	echo $this->Html->script('vendor/fullcalendar/gcal.js', array('charset'=>'UTF-8'));
	echo $this->Html->script('vendor/colorpicker/jquery.simplecolorpicker.js', array('charset'=>'UTF-8'));
	echo $this->Html->script('event', array('charset'=>'UTF-8'));
?>

<?php $calendar_id = empty($this->request->data['calendar_id'])  ? '' : $this->request->data['calendar_id']; ?>
<form id="EventEventuiForm" method="post" accept-charset="utf-8">
<input type="hidden" name="calendar_id" id="EventCalendarId" value="<?php echo $calendar_id; ?>">
</form>

<ul class="nav nav-tabs">
  <li class="<?php echo empty($calendar_id)?'active':''; ?>"><a href="#" class="calendarid">All events</a></li>
	<?php foreach ($calendars as $idx =>$calendar) : ?>
	  <li class="<?php echo ($calendar_id==$idx)?'active':''; ?>">
	  	<a href="#" class="calendarid" id="cid_<?php echo $idx; ?>"><?php echo $calendar;?></a>
	  </li>
	<?php endforeach; ?>
</ul>
<br />


<!-- Calendar -->
<div id="calendar" style="height:700px"></div>

<!--<div id="mydebug" class="col-sm-9 alert alert-success"></div>-->

<div id="delete-confirm" title="Delete Item?">本当に削除しますか？</div>

<div id="dialog-event" title="Event" style="display: none;">
<!--	<p>イベントを追加</p>-->

	<?php
		echo $this->Form->input('calendar_select',array(
			'type'=>'select',
			'label'=>__('Calendars'),
			'options'=>$calendars,
			'class' => 'form-control'
		));
	?>
	<div class="titlepart">
		<label for="name">タイトル</label>
		<input type="text" size="30" name="name" id="event_title" class="form-control" placeholder="Event title" />
	</div>
	<div class="datepart form-group">
		<label for="edate" class="control-label">日付</label>
		<input type="text" name="edate" id="event_date" class="form-control" value="date" />
	</div>
	<div class="detailpart form-group">
		<label for="edetail" class="control-label">詳細</label>
		<textarea name="edetail" id="event_detail" cols=30 rows=3 class="form-control"></textarea>
	</div>
	<div>
		<label for="colorpicker" class="control-label">Color</label>
		<select name="colorpicker" id="event_color">
		  <option value="#7bd148">Green</option>
		  <option value="#5484ed">Bold blue</option>
		  <option value="#a4bdfc">Blue</option>
		  <option value="#46d6db">Turquoise</option>
		  <option value="#7ae7bf">Light green</option>
		  <option value="#51b749">Bold green</option>
		  <option value="#fbd75b">Yellow</option>
		  <option value="#ffb878">Orange</option>
		  <option value="#ff887c">Red</option>
		  <option value="#dc2127">Bold red</option>
		  <option value="#dbadff">Purple</option>
		  <option value="#e1e1e1">Gray</option>
		</select>
	</div>
</div>
