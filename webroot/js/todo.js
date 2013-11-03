$(document).ready(function($){

	// selected item

	var currentItem;

	// sortable start

	$( ".items" ).sortable({
		axis		: 'y',
		placeholder	: 'ui-state-highlight',

		update		: function(){
			var arr = $(".items").sortable('toArray');
			$.post("ajaxrearrange",
				{
					pos:	arr
				}
			);
		}
	});
	$( ".items" ).disableSelection();

	// デバッグ用

	$('#mydebug').hide();
	function cur(v){
//		$('#mydebug').prepend('<div>'+v+'</div');
	}

	// delete confirmation dialog

	$("#delete-confirm").dialog({
		resizable: false,
		modal: true,
		autoOpen:false,

		buttons: {
			'削除': function() {

				// ajaxdelete

				$.post("ajaxdelete/"+currentItem.data('id'),null,function(msg){
					currentItem.fadeOut('normal', function() {currentItem.remove();});
				});

				$(this).dialog('close');
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});

	// move to history confirmation dialog

	$("#history-confirm").dialog({
		resizable: false,
		modal: true,
		autoOpen:false,
		buttons: {
			'移動': function() {

				var pageid = $('#TodoTodopageId').val();
				$.ajax({
					type: "POST",
					async: false,
					url: "ajax2allhistory",
					data:{'todopage_id':pageid},
					success : function() {
//						location.reload(true);
						$( '#TodoTodouiForm' ).submit();	// reload
					}
				});

				$(this).dialog('close');
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});

	// selecting item

	$('.items').on('click', '.item a', function(e){
		e.preventDefault();

		currentItem = $(this).closest('.item');
		currentItem.data('id',currentItem.attr('id'));

		$(this).closest('.item').addClass('itemselected');

	});

	// start edit

	$('.items').on('click', '.item a.edititem', function(e){
		// cur('click a.edititem:' + $(this).closest('.item').attr('id'));
		var container = currentItem.find('.itemtext');

		if ( !currentItem.data('origin') ) {
			currentItem.data('origin', container.text())
		} else {
			return false;
		}

		// insert textbox

		$('<input type="text" class="textbox">')
			.val(container.text())
			.appendTo(container.empty())
			.focus()
			.select();

		e.preventDefault();
	});

	// remove item

	$('.items').on('click', '.item a.removeitem', function(){
		$("#delete-confirm").dialog('open');
	});

	// complete todo

	$('.items').on('click', '.item a.compitem', function(){
		var itemid = currentItem.attr('id');
		var compdate = $.datepicker.formatDate('yy-mm-dd', new Date());
		if ($(this).closest('.item').hasClass('completed')) {

			// cancel completed

			compdate = null;
			$.post("ajaxcomplete",
				{
					'id':itemid,
					'completed':compdate
				}
			);
			$(this).closest('.item').removeClass('completed itemselected').find('.date-completed').remove();
			$(this).closest('.item').find('.tohistory button').attr('disabled','disabled');

		} else {

			// to completed

			$.post("ajaxcomplete",{'id':itemid,'completed':compdate});
			$(this).closest('.item').addClass('completed')
				.find('.date-created')
				.after('<span class="date-completed">' + compdate.substr(5,5) +'</span>');
			$(this).closest('.item').find('.tohistory button').removeAttr('disabled');

		}

	});

	// to history

	$('.items').on('click', '.item a.tohistory', function(){
		if (confirm('選択したアイテムを履歴に移動しますか？') != true) return;
		var itemid = currentItem.attr('id');
		$.post("ajax2history/"+currentItem.data('id'),null,function(msg){
			currentItem.fadeOut('normal', function() {currentItem.remove();});
		});
	});

	// start edit (double click)

	$('.items').on('dblclick', '.item', function(){
		$(this).find('a.edititem').focus().click();
	});

	// emphasis

	$('.items').on('click', '.itemtext', function() {
		$(this).toggleClass('text-danger');
		emphasis = $(this).hasClass("text-danger") ? 1 : 0;

		$.post('ajaxedit',
			{
				'id':	$(this).closest('.item').attr('id'),
				'emphasis'	:emphasis
			}
		);
	});

	// save item if changed

	$('.items').on('blur', '.textbox', function() {

		var text = $.trim(currentItem.find("input[type=text]").val());

		// update todo

		if (text != currentItem.data('origin')) {
//			var itemid = currentItem.attr('id');
			$.post("ajaxedit",
				{
					'id':	currentItem.attr('id'),
					'name':	text
				}
			);
		}

		$(this).closest('.item').removeClass('itemselected');
		currentItem.removeData('origin')
			.find('.itemtext')
			.text(text);
	});

	// keydown(uo, down, reset)

	$('.items').on('keydown', '.textbox', function(e) {
		// ↓、enter
		if(e.which == 13 || e.which == 40) {
			e.preventDefault();
			cur('keydown :' + $(this).closest('.item').attr('id'));
			$(this).closest('.item').next().find('a.edititem').focus().click();
		}
		// escape
		if(e.which == 27) {
			e.preventDefault();
			$(this).val(currentItem.data('origin'));
		}
		// ↑
		if(e.which == 38) {
			e.preventDefault();
			$(this).closest('.item').prev().find('a.edititem').focus().click();
		}
		// insert item into next posion
		if(e.which == 45 && !e.shiftKey) {
			e.preventDefault();
			$('#addButton').focus().click();
		}
	});

	// checkbox selected

	$('.items').on('click', 'input[type=checkbox]', function(){
		$(this).closest('.item').toggleClass('checked');
	});

	// add new item

	$('#addButton').click(function(e){

		var pageid = $('#TodoTodopageId').val();
		$.post("ajaxadd",{'name':'New Item.','todopage_id':pageid},function(msg){

			// Appending the new todo and fading it into view:
			$(msg).hide().prependTo('.items').fadeIn().find('a.edititem').focus().click();
		});

		e.preventDefault();
	});

	// move completed items to history

	$('#historyButton').click(function(){
		$("#history-confirm").dialog('open');
	});

	// remove checked items

	$('#removeAllButton').click(function(){
		if (confirm('選択したアイテムを本当に削除しますか？') != true) return;

		var checks=[];
        $('.items input:checked').each(function(){
            checks.push(this.value);
        });

		$.ajax({
			type: "POST",
			async: false,
			url: "ajaxremovechecks",
			data: {removes:checks},
			success : function() {
//				location.reload(true);
				$( '#TodoTodouiForm' ).submit();
			}
		});
	});

	// page change

	$('.todopageid').click(function(e){

		// get page-id

		cid = $(this).attr('id');
		if (cid) cid = cid.replace('cid_','');

		// submit

		$('#TodoTodopageId').val(cid);
		$('#TodoTodouiForm').submit();
		e.preventDefault();
	});

});