$(document).ready(function($){

	var currentItem;
	
	$( ".items" ).sortable({
		axis		: 'y',
		placeholder	: 'ui-state-highlight',
		update		: function(){
			var arr = $(".items").sortable('toArray');
			$.post("ajaxrearrange",{pos:arr});
		}
	});
	$( ".items" ).disableSelection();


	
	function cur(v){
		$('#mydebug').prepend('<div>'+v+'</div');
//		$('#mydebug').html(currentItem.find('.itemtext').text());
	}
	
	$("#delete-confirm").dialog({
		resizable: false,
		// height:130,
		modal: true,
		autoOpen:false,
		buttons: {
			'Delete': function() {
				
				$.post("ajaxdelete/"+currentItem.data('id'),null,function(msg){
					currentItem.fadeOut('normal', function() {currentItem.remove();});
				});
				// currentTODO.remove();
				
				$(this).dialog('close');
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});	
	
	
	$('.items').on('click', '.item a', function(e){
		
//		cur('click item a:' + $(this).closest('.item').attr('id'));
		
		currentItem = $(this).closest('.item');
		currentItem.data('id',currentItem.attr('id'));
		
		$(this).closest('.item').addClass('itemselected');
		
		e.preventDefault();
	});
				   
	$('.items').on('click', '.item a.edititem', function(){
//		cur('click a.edititem:' + $(this).closest('.item').attr('id'));
		var container = currentItem.find('.itemtext');
		
		if(!currentItem.data('origin')) {
			currentItem.data('origin', container.text())
		} else {
			return false;
		}
		
		$('<input type="text" class="textbox" style="width:70%;">')
			.val(container.text())
			.appendTo(container.empty())
			.focus();
	});
	
	$('.items').on('click', '.item a.removeitem', function(){
		$("#delete-confirm").dialog('open');
	});

	$('.items').on('click', '.item a.compitem', function(){
		var itemid = currentItem.attr('id');
		var compdate = $.datepicker.formatDate('yy-mm-dd', new Date());
		if ($(this).closest('.item').hasClass('completed')) {
			compdate = null;
			$.post("ajaxcomplete",{'id':itemid,'completed':compdate});
			$(this).closest('.item').removeClass('completed itemselected').find('.date-completed').remove();
		} else {
			$.post("ajaxcomplete",{'id':itemid,'completed':compdate});
			$(this).closest('.item').addClass('completed');
		}
		
	});

	$('.items').on('dblclick', '.item', function(){
		$(this).find('a.edititem').focus().click();
	});
	
//	$(document).on('blur', '.textbox', function() {
	$('.items').on('blur', '.textbox', function() {
//		cur('blur :' + $(this).closest('.item').attr('id') + ' / origin : ' +  currentItem.attr('id') + ' : '+ currentItem.data('origin'));
				
		var text = currentItem.find("input[type=text]").val();

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
//		cur('keydown : '+ e.which);
	});
	
	$('#addButton').click(function(e){

		// $.get("ajax.php",{'action':'new','text':'New Todo Item. Doubleclick to Edit.','rand':Math.random()},function(msg){
		$.post("ajaxadd",{'name':'New Item.'},function(msg){

			// Appending the new todo and fading it into view:
			$(msg).hide().prependTo('.items').fadeIn().find('a.edititem').focus().click();
		});
		
		e.preventDefault();
	});
	
	$('#historyButton').click(function(){
		$.ajax({
			type: "POST",
			async: false,
			url: "ajax2history",
			success : function() {
				location.reload();
			}
		});
	});
});