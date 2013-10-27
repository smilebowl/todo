$(document).ready(function($){
	
	var curStart;
	var curEvent;
	
	var calendar = $('#calendar').fullCalendar({
	
		editable: true,
		firstDay: 1, // 1:月曜日

		selectable: true,
		selectHelper: true,//			theme: true,

		titleFormat: {
			month: 'yyyy年 M月',
			week: '[yyyy年 ]M月 d日{ &#8212;[yyyy年 ][ M月] d日}',
			day: 'yyyy年 M月 d日 dddd'
		},		
		events: "ajaxloadevent",
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

		
		select: function(start, end, allDay, jsEvent, view) {
//			var title = prompt('Event Title:');
			curStart = start;
			$('#event_date').hide();
			$('#dialog-event').dialog('open');
//			if (title) {
//				calendar.fullCalendar('renderEvent',
//					{
//						title: title,
//						start: start,
//						end: end,
//						allDay: allDay
//					},
//					true // make the event "stick"
//				);
//			}
			calendar.fullCalendar('unselect');
		},
		
		eventClick:function(event, jsEvent, view){
//			'dialog-event'
			curEvent = event;
			
			$('#event_date').show();
			$('#event_title').val(event.title);
			$('#event_date').val($.fullCalendar.formatDate(event.start, 'yyyy-MM-dd'));
			$('#dialog-event').dialog('open');
		},
		
		eventDrop: function(event, delta) {
			alert(event.title + ' was moved ' + delta + ' days\n' +
				'(should probably update your database)');
		},
		
		loading: function(bool) {
			if (bool) $('#loading').show();
			else $('#loading').hide();
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
				
				if (curEvent) {
					curEvent.title = $('#event_title').val();
					curEvent.start = $('#event_date').val();
//					curEvent.start = $.fullCalendar.parseISO8601($('#event_date').val());
					var id = curEvent.id;
					$.post("ajaxupdate",{'id':id, 'title':title, 'start':start},function(msg){
						calendar.fullCalendar('updateEvent', curEvent);
					});
				} else {
					title = $('#event_title').val();
					$.post("ajaxnewevent",{'title':title, 'start':start},function(id){
//						alert(id);
						calendar.fullCalendar('renderEvent',
							{
								id: id,
								title: title,
								start: curStart,
		//						end: end,
		//						allDay: allDay
							},
							true // make the event "stick"
						);
					});
				};
//				var note_title = $('#note_title').val();
//				var note_text = $('#note_text').val();
//				var note_category = $('#NoteCategoryId').val();
//				$.post("ajaxnewnote",{'name':note_title,'text':note_text, 'category_id':note_category},function(msg){
//		
//					// Appending the new note
//					$(msg).hide().prependTo('.notes').fadeIn();
////					location.reload(true);
//					$('#NoteNoteuiForm').submit();
//				
//				});				
				
				$(this).dialog('close');
//				curEvent = null;
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});
	
	$('#event_date').datepicker({
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		showAnim: 'show'
	});
	$('#ui-datepicker-div').hide();


});
