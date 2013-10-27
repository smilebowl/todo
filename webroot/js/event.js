$(document).ready(function($){
	
	var curStart;　// for insert
	var curEvent;  // for update
	var e_update;
	
	var calendar = $('#calendar').fullCalendar({
	
		editable: true,
		firstDay: 1, // 1:月曜日

		selectable: true,
		selectHelper: true,
//		theme: true,

		titleFormat: {
			month: 'yyyy年 M月',
			week: '[yyyy年 ]M月 d日{ &#8212;[yyyy年 ][ M月] d日}',
			day: 'yyyy年 M月 d日 dddd'
		},
		
		// return json
		
		events: "ajaxloadevent",
		
		// google calendar
		
		eventSources: [
			{
				url:'https://www.google.com/calendar/feeds/ja.japanese%23holiday%40group.v.calendar.google.com/public/basic',
				color:'#f8d3d4',
				textColor:'#666',
				success:function(events){
					$(events).each(function(){
						this.url = null;
					});     
				},
			}
		],

		// add event
		
		select: function(start, end, allDay, jsEvent, view) {
			curStart = start;
			$('.datepart').hide();
			$('#dialog-event').dialog('open');
			calendar.fullCalendar('unselect');
		},
		
		// update event
		
		eventClick: function(event, jsEvent, view){
			curEvent = event;
			e_update = true;
			
			$('.datepart').show();
			$('#event_title').val(event.title);
			$('#event_date').val($.fullCalendar.formatDate(event.start, 'yyyy-MM-dd'));
//			alert(event.color);
			
			$('#event_color').val(event.color);
//			$('#event_color').simplecolorpicker({theme: 'glyphicons'});
//			colorpicker('selectColor', event.color);
			$('#dialog-event').dialog('open');
			
//			$('#event_color').simplecolorpicker('destroy');
			
		},
		
		eventDrop: function(event, delta) {
//			alert(event.title + ' was moved ' + delta + ' days\n' +
//				'(should probably update your database)');
			var id = event.id;
			var nstart = $.fullCalendar.formatDate(event.start, 'yyyy-MM-dd');
			var nend = $.fullCalendar.formatDate(event.end, 'yyyy-MM-dd');
			$.post("ajaxupdate",{'id':id, 'start':nstart, 'end':nend},function(msg){
				calendar.fullCalendar('updateEvent', event);
			});
		},
		
		eventResize: function( event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view ) {
			var id = event.id;
			var nstart = $.fullCalendar.formatDate(event.start, 'yyyy-MM-dd');
			var nend = $.fullCalendar.formatDate(event.end, 'yyyy-MM-dd');
			$.post("ajaxupdate",{'id':id, 'start':nstart, 'end': nend},function(msg){
				calendar.fullCalendar('updateEvent', event);
			});
		}

	});

	$("#dialog-event").dialog({
		resizable: false,
		modal: true,
		autoOpen:false,
		buttons: {
			'OK': function() {
				
				var title;
				var start = $.fullCalendar.formatDate(curStart, 'yyyy-MM-dd');
				
				if (e_update) {
					
					// update
					curEvent.title = $('#event_title').val();
					curEvent.start = $('#event_date').val();
					curEvent.color = $('#event_color').val();
					var id = curEvent.id;
					$.post("ajaxupdate",
						   	{'id':id, 'title':curEvent.title, 'start':curEvent.start, 'color':curEvent.color},
						function(msg){
							calendar.fullCalendar('updateEvent', curEvent);
					});
					
				} else {
					
					// new event
					
					title = $('#event_title').val();
					var color = $('#event_color').val();
					$.post("ajaxnewevent",{'title':title, 'start':start, 'color':color},function(id){
						calendar.fullCalendar('renderEvent',
							{
								id: id,
								title: title,
								start: curStart,
		//						end: end,
								color: $('#event_color').val()
							},
							true // make the event "stick"
						);
					});
				};
				
				$(this).dialog('close');
//				e_update = false;
//				$('#event_color').simplecolorpicker('destroy');
			},
			Cancel: function() {
				$(this).dialog('close');
			},
		},
		open: function( event, ui ) {
			$('#event_color').simplecolorpicker({theme: 'glyphicons'});
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
	$('#ui-datepicker-div').hide();
	
//	var colorpicker = $('#event_color').simplecolorpicker({
////		picker: true,
//		theme: 'glyphicons'
//	});


});
