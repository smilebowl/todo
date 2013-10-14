$(document).ready(function($){


//	$( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
//		.find( ".portlet-header" )
//		.addClass( "ui-widget-header ui-corner-all" )
//		.prepend( "<span class='ui-icon ui-icon-close'></span>")
//		.end()
//		.find( ".portlet-content" );
	
	$('.notes').on('click', '.portlet-header .ui-icon', function(){
		if (!confirm("削除しますか")) return;
		
		var curnote = $( this ).closest('.portlet');
		var itemid = curnote.attr('id');
		$.post("ajaxdelete/"+itemid, null, function() {
			curnote.fadeOut('normal', function() {curnote.remove();});
		});
	});
//	$( ".column" ).disableSelection();
	
	$( ".portlet" ).draggable({
		handle: ".portlet-header",
		stack: ".portlet",
		stop: function(event, ui) {
			 var xyz = ui.position.left +"."+ ui.position.top + "." + $( this ).zIndex();
			 var itemid = $( this ).attr('id');
			 $.post("ajaxupdate",{'id':itemid,'xyz':xyz});
		}
	});

	$( ".portlet").resizable({
		stop: function( event, ui ) {
			var itemid = $( this ).attr('id');
			var wh = ui.size.width +"."+ ui.size.height;
			$.post("ajaxupdate",{'id':itemid,'wh':wh});
		}
	});

	$('#main').on('blur', 'div[contenteditable]', function() {
		var text = $(this).html();
		var itemid = $( this ).closest('.portlet').attr('id');
		$.post("ajaxupdate",{'id':itemid,'text':text});
	});
	
	$("#dialog-newnote").dialog({
		resizable: false,
		modal: true,
		autoOpen:false,
		buttons: {
			'New note': function() {

				var note_title = $('#note_title').val();
				var note_text = $('#note_text').val();
				$.post("ajaxnewnote",{'name':note_title,'text':note_text},function(msg){
		
					// Appending the new todo and fading it into view:
					$(msg).hide().prependTo('.notes').fadeIn();
					location.reload(true);
				
				});				
				
				$(this).dialog('close');
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});
	
	$('#addButton').click(function(){
		$("#dialog-newnote").dialog('open');
	});
	
});	