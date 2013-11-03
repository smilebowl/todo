$(document).ready(function($){


	// draggable start
	
	$( ".portlet" ).draggable({
		handle: ".portlet-header",
		stack: ".portlet",
		stop: function(event, ui) {
			
			var allxyz=[];
			$('.portlet').each(function(){
				pos = $(this).position();
				curxyz = pos.left +"."+ pos.top + "." + $(this).zIndex();
				allxyz.push( {'id':$(this).attr('id') ,'xyz':curxyz} );
			});
			$.post('ajaxallpositon', {'allxyz':allxyz});
			
//			 var xyz = ui.position.left +"."+ ui.position.top + "." + $( this ).zIndex();
//			 var itemid = $( this ).attr('id');
//			 $.post("ajaxupdate",
//				{
//					'id': $( this ).attr('id'),
//					'xyz': ui.position.left +"."+ ui.position.top + "." + $( this ).zIndex()
//				}
//			);
		}
	});

	// resizable start
	
	$( ".portlet").resizable({
		stop: function( event, ui ) {
			var itemid = $( this ).attr('id');
			var wh = ui.size.width +"."+ ui.size.height;
			$.post("ajaxupdate",{'id':itemid,'wh':wh});
		}
	});

	
	// remove note
	
	$('.notes').on('click', '.ui-icon-close', function(){
		if (!confirm("削除しますか？")) return;
		
		var curnote = $( this ).closest('.portlet');
		var itemid = curnote.attr('id');
		$.post("ajaxdelete/"+itemid, null, function() {
			curnote.fadeOut('normal', function() {curnote.remove();});
		});
	});
	
	// reset format
	
	$('.notes').on('click', '.ui-icon-pause', function(){
		if (!confirm("書式をリセットしますか？")) return;
		
		var curnote = $( this ).closest('.portlet');
		var itemid = curnote.attr('id');
		var text = curnote.find('.portlet-content').text();
		$.post("ajaxupdate",{'id':itemid,'text':text}, function() {
			 curnote.find('.portlet-content').text(text);
		});
	});

	// save text
	
	$('#notepage').on('blur', 'div[contenteditable]', function() {
		var text = $(this).html();
		var portl = $(this).closest('.portlet');
		var itemid = portl.attr('id');
		
		var h = $(this).height() + portl.find('.portlet-header').height()+26;
		portl.height(h);
		var wh = portl.outerWidth() + "." + portl.outerHeight();
		
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
	
	var targetTitleChange;	// target object for title change
	
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
		$('#note_newtitle').val($.trim($(this).text()));
		$("#dialog-title").dialog('open');
	});

	// page change
	
	$('.categoryid').click(function(e){
		
		// get page-id
		
		cid = $(this).attr('id');
		if (cid) cid = cid.replace('cid_','');
		
		// submit
		
		$('#NoteCategoryId').val(cid);
		$('#NoteNoteuiForm').submit();
		
		e.preventDefault();
	});	
});	