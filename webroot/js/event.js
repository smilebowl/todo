$(document).ready(function($){

	var curEvent;	// selected event object for update
	var e_update;	// flag

	var calendar = $('#calendar').fullCalendar({
		header: {
//			left: 'prev,next today',
//			center: 'title',
//			right: 'month,basicWeek',
			ignoreTimezone: false
		},
		editable: true,
		firstDay: 1, // 1:Monday

		selectable: true,
		selectHelper: true,
//		theme: true,

		titleFormat: {
			month: 'yyyy年 M月',
			week: '[yyyy年 ]M月 d日{ &#8212;[yyyy年 ][ M月] d日}',
			day: 'yyyy年 M月 d日 dddd'
		},

		// return json

		events: {
			url: "ajaxloadevent",
			data : {'calendar_id':$('#EventCalendarId').val()}
		},

		// google holiday calendar(Japanese)

		eventSources: [
			{
				url:'https://www.google.com/calendar/feeds/ja.japanese%23holiday%40group.v.calendar.google.com/public/basic',
				color:'#f8d3d4',
				textColor:'#000',
				editable:false,
				success:function(events){
					$(events).each(function(){
						this.url = null;	// remove link
					});
				},
			}
		],

		// new event

		select: function(start, end, allDay, jsEvent, view) {

			// initialize dialog items for new event

			$('#event_date').val($.fullCalendar.formatDate(start, 'yyyy-MM-dd'));
			$('#event_title').val('');
			$('#event_detail').val(null);
			$('#calendar_select').val($('#EventCalendarId').val());
			dlg_event.dialog('option', 'title', 'New event');

			// open dialog

			$('#dialog-event').dialog('open');
			calendar.fullCalendar('unselect');
		},

		// update event

		eventClick: function(event, jsEvent, view){

			if (!$.isNumeric(event.id)) return; // skip google calender

			curEvent = event;
			e_update = true;


			// initialize dialog for update

			$('.datepart').show();
			$('#event_title').val(event.title);
			$('#event_date').val($.fullCalendar.formatDate(event.start, 'yyyy-MM-dd'));

			// get event record from server

			$.ajax({
				type:	'post',
				url:	"ajaxgetrecord",
				data:	{'id':	event.id},
				dataType:	"json",
				success: function(data, dataType){
					$('#event_detail').val(data.detail);
					$('#calendar_select').val(data.calendar_id);
				}
			});

			$('#event_color').val(event.color);
			dlg_event.dialog('option', 'title', 'Update event');

			// open dialog

			$('#dialog-event').dialog('open');

		},

		// event droped

		eventDrop: function(event, delta) {

			$.post("ajaxupdate",
				{
					'id':		event.id,
					'start':	$.fullCalendar.formatDate(event.start, 'yyyy-MM-dd'),
					'end':		$.fullCalendar.formatDate(event.end, 'yyyy-MM-dd')
				},
				function(){
					calendar.fullCalendar('updateEvent', event);
				}
			);
		},

		eventResize: function( event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view ) {

			$.post("ajaxupdate",
				{
					'id':		event.id,
					'start':	$.fullCalendar.formatDate(event.start, 'yyyy-MM-dd'),
					'end': 		$.fullCalendar.formatDate(event.end, 'yyyy-MM-dd')
				},
				function(){
					calendar.fullCalendar('updateEvent', event);
				}
			);
		}

	});

	var dlg_event = $("#dialog-event").dialog({
		resizable: false,
		modal: true,
		width: '420px',
		autoOpen:false,
		show: "slide",

		buttons: {
			'OK': function() {

				if (!$('#event_title').val()) {
					alert('Title is empty.');
					return;
				}

				if (e_update) {

					// update

					curEvent.title = $('#event_title').val();
					curEvent.start = $('#event_date').val();
					curEvent.color = $('#event_color').val();
//					var id = curEvent.id;
					$.post("ajaxupdate",
						{
							'id':		curEvent.id,
							'title':	curEvent.title,
							'start':	curEvent.start,
							'color':	curEvent.color,
							'detail':	$('#event_detail').val(),
							'calendar_id':$('#calendar_select').val()
						},
						function(msg){
							calendar.fullCalendar('updateEvent', curEvent);
					});

				} else {

					// new event

					var title = $('#event_title').val();
					var start = $('#event_date').val();
					var color = $('#event_color').val();
					$.post("ajaxnewevent",
						{
							'title':	title,
						 	'start':	start,
						 	'color':	color,
						 	'detail':	$('#event_detail').val(),
						 	'calendar_id':$('#calendar_select').val()
						},
						function(id){

						if (id) {
							calendar.fullCalendar('renderEvent',
								{
									id: id,
									title: title,
									start: start,
									color: color
								},
								true // make the event "stick"
							);
						}
					});
				};

				$(this).dialog('close');
			},
			Cancel: function() {
				$(this).dialog('close');
			},
			Delete: function() {
				if (!confirm("削除しますか？")) return;

				$.post("ajaxdelete/" + curEvent.id, null, function() {
					calendar.fullCalendar('removeEvents', curEvent.id);
				});

				$(this).dialog('close');
			},
		},

		open: function( event, ui ) {
			$('#event_color').simplecolorpicker({theme: 'glyphicons'});
			if (e_update) {
				$('.ui-dialog-buttonpane').find('button:contains("Delete")').show();
			} else {
				$('.ui-dialog-buttonpane').find('button:contains("Delete")').hide();
			}
//			$('#event_title').select();
		},
		close: function( event, ui ) {
			e_update = false;
			$('#event_color').simplecolorpicker('destroy');
		}
	});

	// jquery datepicker
//	$.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
	$('#event_date').datepicker({
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		showAnim: 'show'
	});

	// hide

	$('#ui-datepicker-div').hide();

	// click tab

	$('.calendarid').click(function(e){
		e.preventDefault();

		// get calendar-id

		cid = $(this).attr('id');
		if (cid) cid = cid.replace('cid_','');

		// reload

		$('#EventCalendarId').val(cid);
		$('#EventEventuiForm').submit();
	});

});
