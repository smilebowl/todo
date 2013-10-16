$(document).ready(function($){


//	$( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
//		.find( ".portlet-header" )
//		.addClass( "ui-widget-header ui-corner-all" )
//		.prepend( "<span class='ui-icon ui-icon-close'></span>")
//		.end()
//		.find( ".portlet-content" );
//	$( ".column" ).disableSelection();
	
	// draggable
	
	$( ".portlet" ).draggable({
		handle: ".portlet-header",
		stack: ".portlet",
		stop: function(event, ui) {
			 var xyz = ui.position.left +"."+ ui.position.top + "." + $( this ).zIndex();
			 var itemid = $( this ).attr('id');
			 $.post("ajaxupdate",{'id':itemid,'xyz':xyz});
		}
	});

	// resizable
	
	$( ".portlet").resizable({
		stop: function( event, ui ) {
			var itemid = $( this ).attr('id');
			var wh = ui.size.width +"."+ ui.size.height;
			$.post("ajaxupdate",{'id':itemid,'wh':wh});
		}
	});

	// select category
	
	$("#NoteCategoryId").change(function () {
		$(this).closest('form').submit();
	});
	
	// remove note
	
	$('.notes').on('click', '.ui-icon-close', function(){
		if (!confirm("削除しますか")) return;
		
		var curnote = $( this ).closest('.portlet');
		var itemid = curnote.attr('id');
		$.post("ajaxdelete/"+itemid, null, function() {
			curnote.fadeOut('normal', function() {curnote.remove();});
		});
	});

	// toggle
	
//	$('.notes').on('click', '.ui-icon-minusthick', function(){
//		$( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
//		$( this ).closest( ".portlet" ).find( ".portlet-content" ).toggle();
//	});

	// save text
	
	$('#notepage').on('blur', 'div[contenteditable]', function() {
		var text = $(this).html();
		var portl = $(this).closest('.portlet');
		var itemid = portl.attr('id');
		
		var h = $(this).height() + portl.find('.portlet-header').height()+26;
		portl.height(h);
		var wh = portl.width() + "." + portl.height();
		
		$.post("ajaxupdate",{'id':itemid,'text':text, 'wh':wh});
	});
	
	// new note
	
	$("#dialog-newnote").dialog({
		resizable: false,
		modal: true,
		autoOpen:false,
		buttons: {
			'OK': function() {

				var note_title = $('#note_title').val();
				var note_text = $('#note_text').val();
				var note_category = $('#NoteCategoryId').val();
				$.post("ajaxnewnote",{'name':note_title,'text':note_text, 'category_id':note_category},function(msg){
		
					// Appending the new note
					$(msg).hide().prependTo('.notes').fadeIn();
//					location.reload(true);
					$('#NoteNoteuiForm').submit();
				
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

	// change title
	
	var targetTitleChange;	
	$("#dialog-title").dialog({
		resizable: false,
		modal: true,
		autoOpen:false,
		buttons: {
			'OK': function() {

				var itemid = targetTitleChange.closest('.portlet').attr('id');
				var ntitle = $('#note_newtitle').val();
				$.post("ajaxupdate",{'id':itemid,'name':ntitle});
				targetTitleChange.text(ntitle);
				
				$(this).dialog('close');
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});
	
	$('.portlet-header').dblclick(function() {
		targetTitleChange = $(this);
		$('#note_newtitle').val($(this).text());
		$("#dialog-title").dialog('open');
	});
	
});	