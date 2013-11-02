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
				textColor:'#666',
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
			$('#event_title').val('New event');
			$('#event_detail').val(null);
			$('#calendar_select').val($('#EventCalendarId').val());
			
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
			
			$.post("ajaxgetdetail",	{'id':event.id}, function(msg){
				$('#event_detail').val(msg);
			});
			$('#event_color').val(event.color);
			$.post("ajaxgetcid",	{'id':event.id}, function(msg){
				$('#calendar_select').val(msg);
			});
			
			// open dialog 
			
			$('#dialog-event').dialog('open');
			
		},
		
		eventDrop: function(event, delta) {
			var id = event.id;
			var nstart = $.fullCalendar.formatDate(event.start, 'yyyy-MM-dd');
			var nend = $.fullCalendar.formatDate(event.end, 'yyyy-MM-dd');
			$.post("ajaxupdate",{'id':id, 'start':nstart, 'end':nend},function(){
				calendar.fullCalendar('updateEvent', event);
			});
		},
		
		eventResize: function( event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view ) {
			var id = event.id;
			var nstart = $.fullCalendar.formatDate(event.start, 'yyyy-MM-dd');
			var nend = $.fullCalendar.formatDate(event.end, 'yyyy-MM-dd');
			$.post("ajaxupdate",{'id':id, 'start':nstart, 'end': nend},function(){
				calendar.fullCalendar('updateEvent', event);
			});
		}

	});

	$("#dialog-event").dialog({
		resizable: false,
		modal: true,
		width: '420px',
		autoOpen:false,
		show: "slide",
		
		buttons: {
			'OK': function() {
				
				if (e_update) {
					
					// update
					
					curEvent.title = $('#event_title').val();
					curEvent.start = $('#event_date').val();
					curEvent.color = $('#event_color').val();
					var id = curEvent.id;
					$.post("ajaxupdate",
						{'id':id,
						 'title':curEvent.title,
						 'start':curEvent.start,
						 'color':curEvent.color,
						 'detail':$('#event_detail').val(),
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
						{'title':title,
						 'start':start,
						 'color':color,
						 'detail':$('#event_detail').val(),
						 'calendar_id':$('#calendar_select').val()
						},
					  function(id){

						if (id) {
							calendar.fullCalendar('renderEvent',
								{
									id: id,
									title: title,
									start: $('#event_date').val(),
									color: $('#event_color').val()
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
		},
		close: function( event, ui ) {
			e_update = false;
			$('#event_color').simplecolorpicker('destroy');
		}
	});
	
	// datepicker
	
	$('#event_date').datepicker({
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		showAnim: 'show'
	});
	
	// hide 
	
	$('#ui-datepicker-div').hide();
	
	// click tab
	
	$('.calendarid').click(function(e){
		cid = $(this).attr('id');
		if (cid) cid = cid.replace('cid_','');
		$('#EventCalendarId').val(cid);
		$('#EventEventuiForm').submit();
		e.preventDefault();
	});

});
