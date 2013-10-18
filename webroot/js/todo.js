$(document).ready(function($){

	// selected item
	
	var currentItem;
	
	// sortable
	
	$( ".items" ).sortable({
		axis		: 'y',
		placeholder	: 'ui-state-highlight',
		update		: function(){
			var arr = $(".items").sortable('toArray');
			$.post("ajaxrearrange",{pos:arr});
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
			'Delete': function() {

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
				
				$.ajax({
					type: "POST",
					async: false,
					url: "ajax2allhistory",
					success : function() {
						location.reload(true);
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
		
		currentItem = $(this).closest('.item');
		currentItem.data('id',currentItem.attr('id'));
		
		$(this).closest('.item').addClass('itemselected');
		
		e.preventDefault();
	});
	
	// start edit
	
	$('.items').on('click', '.item a.edititem', function(){
		// cur('click a.edititem:' + $(this).closest('.item').attr('id'));
		var container = currentItem.find('.itemtext');
		
		if(!currentItem.data('origin')) {
			currentItem.data('origin', container.text())
		} else {
			return false;
		}
		
		// insert textbox
		
		$('<input type="text" class="textbox">')
			.val(container.text())
			.appendTo(container.empty())
			.focus();
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
			
			// to uncompleted
			
			compdate = null;
			$.post("ajaxcomplete",{'id':itemid,'completed':compdate});
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
	
	// save item if changed
	
	$('.items').on('blur', '.textbox', function() {
		// cur('blur :' + $(this).closest('.item').attr('id') + ' / origin : ' +  currentItem.attr('id') + ' : '+ currentItem.data('origin'));
				
		var text = $.trim(currentItem.find("input[type=text]").val());

		if (text == currentItem.data('origin')) {
			cur('update : none ' + currentItem.attr('id') );
		} else {
			cur('update : yes ' + currentItem.attr('id') );
			var itemid = currentItem.attr('id');
			$.post("ajaxedit",{'id':itemid,'name':text});
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
			cur('keydown :' + $(this).closest('.item').attr('id'));
			$(this).closest('.item').next().find('a.edititem').focus().click();
			e.preventDefault();
		}
		// escape
		if(e.which == 27) {
			$(this).val(currentItem.data('origin'));
			e.preventDefault();
		}
		// ↑
		if(e.which == 38) {
			$(this).closest('.item').prev().find('a.edititem').focus().click();
			e.preventDefault();
		}
//		// insert item into next posion
		if(e.which == 45 && !e.shiftKey) {
			$('#addButton').focus().click();
			e.preventDefault();
		}
		cur('keydown : '+ e.which);
	});
	
	// add new item
	
	$('#addButton').click(function(e){

		// $.get("ajax.php",{'action':'new','text':'New Todo Item. Doubleclick to Edit.','rand':Math.random()},function(msg){
		$.post("ajaxadd",{'name':'New Item.'},function(msg){

			// Appending the new todo and fading it into view:
			$(msg).hide().prependTo('.items').fadeIn().find('a.edititem').focus().click();
		});
		
//		e.preventDefault();
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
		
//		$.post("ajaxrearrange",{pos:arr});
		$.ajax({
			type: "POST",
			async: false,
			url: "ajaxremovechecks",
			data: {removes:checks},
			success : function() {
				location.reload(true);
			}
		});
	});
	
});