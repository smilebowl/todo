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
			$.post('ajaxallpositon',
				{
					'allxyz':allxyz
				}
			);
		}
	});

	// resizable start

	$( ".portlet").resizable({
		stop: function( event, ui ) {
//			var itemid = $( this ).attr('id');
//			var wh = ui.size.width +"."+ ui.size.height;
			$.post("ajaxupdate",
				{
					'id':	$( this ).attr('id'),
					'wh':	ui.size.width +"."+ ui.size.height
				}
			);
		}
	});


	// remove note

	$('.notes').on('click', '.ui-icon-close', function(){
		if (!confirm("削除しますか？")) return;

		var currentnote = $( this ).closest('.portlet');
		var itemid = currentnote.attr('id');
		$.post("ajaxdelete/"+itemid, null, function() {
			currentnote.fadeOut('normal', function() {currentnote.remove();});
		});
	});

	// reset format

	$('.notes').on('click', '.ui-icon-pause', function(){
		if (!confirm("書式をリセットしますか？")) return;

		var currentnote = $( this ).closest('.portlet');
//		var itemid = curnote.attr('id');
		var text = currentnote.find('.portlet-content').text();
		$.post("ajaxupdate",
			{
			   'id': currentnote.attr('id'),
			   'text':text
			},
			function() {
			 		currentnote.find('.portlet-content').text(text);
			}
		);
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

				if (!$('#note_title').val()) {
					alert('Title is empty.');
					return;
				}

				$.post("ajaxnewnote",
					{
						'name':	$('#note_title').val(),
						'text':	$('#note_text').val(),
						'category_id':	$('#NoteCategoryId').val()
					},
					function(msg){

						// Appending the new note
						$(msg).hide().prependTo('.notes').fadeIn();
						$('#NoteNoteuiForm').submit();	// reload

					}
				);

				$(this).dialog('close');
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});

	// open dialog for new note

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

				if (!$('#note_newtitle').val()) {
					alert('Title is empty.');
					return;
				}

				$.post("ajaxupdate",
					{
						'id':	targetTitleChange.closest('.portlet').attr('id'),
						'name':	$('#note_newtitle').val()
					}
				);
				targetTitleChange.text($('#note_newtitle').val());

				$(this).dialog('close');
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});

	// set target note to variable

	$('.portlet-header').dblclick(function() {
		targetTitleChange = $(this);
		$('#note_newtitle').val($.trim($(this).text()));
		$("#dialog-title").dialog('open');
	});

	// page change

	$('.categoryid').click(function(e){

		e.preventDefault();

		// get page-id

		cid = $(this).attr('id');
		if (cid) cid = cid.replace('cid_','');

		// submit

		$('#NoteCategoryId').val(cid);
		$('#NoteNoteuiForm').submit();

	});
});