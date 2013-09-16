$(document).ready(function(){
	/* The following code is executed once the DOM is loaded */

	$(".todoList").sortable({
		axis		: 'y',				// Only vertical movements allowed
		containment	: 'window',			// Constrained by the window
		update		: function(){		// The function is called after the todos are rearranged
		
			// The toArray method returns an array with the ids of the todos
			var arr = $(".todoList").sortable('toArray');
			
			// Striping the todo- prefix of the ids:
			
			
			// arr = $.map(arr,function(val,key){
				// return val.replace('todo-','');
			// });
			
			// Saving with AJAX
			// $.get('ajax.php',{action:'rearrange',positions:arr});
			
			var data = $(this).sortable('serialize');
			$.post("ajaxrearrange",{pos:arr});
		},
		
		/* Opera fix: */
		
		stop: function(e,ui) {
			ui.item.css({'top':'0','left':'0'});
		}
	});
	
	// A global variable, holding a jQuery object 
	// containing the current todo item:
	
	var currentTODO;
	
	// Configuring the delete confirmation dialog
	$("#dialog-confirm").dialog({
		resizable: false,
		// height:130,
		modal: true,
		autoOpen:false,
		buttons: {
			'Delete item': function() {
				
				$.post("ajaxdelete/"+currentTODO.data('id'),null,function(msg){
					currentTODO.fadeOut('fast');
				});
				currentTODO.remove();
				
				$(this).dialog('close');
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		}
	});

	// When a double click occurs, just simulate a click on the edit button:
	$(document).on('dblclick', '.todo', function(){
		$(this).find('a.edit').click();
	});
	
	// If any link in the todo is clicked, assign
	// the todo item to the currentTODO variable for later use.

	$(document).on('click', '.todo a', function(e){
									   
		currentTODO = $(this).closest('.todo');
		// currentTODO.data('id',currentTODO.attr('id').replace('todo-',''));
		currentTODO.data('id',currentTODO.attr('id'));
		
		e.preventDefault();
	});

	// Listening for a click on a delete button:

	$(document).on('click', '.todo a.delete', function(){
		$("#dialog-confirm").dialog('open');
	});
	
	// Listening for a click on a edit button
	
	$(document).on('click', '.todo a.edit', function(){

		var container = currentTODO.find('.text');
		
		if(!currentTODO.data('origText'))
		{
			// Saving the current value of the ToDo so we can
			// restore it later if the user discards the changes:
			
			currentTODO.data('origText',container.text());
		}
		else
		{
			// This will block the edit button if the edit box is already open:
			return false;
		}
		
		// $('<input type="text">').val(container.text()).appendTo(container.empty());
		// $('<input type="text">').val(container.text()).appendTo(container.empty()).focus();
		$('<input type="text">').val(container.text()).appendTo(container.empty()).focus();
		
		// Appending the save and cancel links:
		container.append(
			'<div class="editTodo">'+
				'<a class="saveChanges" href="#">Save</a> or <a class="discardChanges" href="#">Cancel</a>'+
			'</div>'
		);
		
	});
	
	// The cancel edit link:
	
	$(document).on('click', '.todo a.discardChanges', function(){
		currentTODO.find('.text')
					.text(currentTODO.data('origText'))
					.end()
					.removeData('origText');
	});
	
	// The save changes link:
	
	$(document).on('click', '.todo a.saveChanges', function(){
		var text = currentTODO.find("input[type=text]").val();
		
		if (text=='') {
		    alert('未入力です。');
		    return false;
		}
		
//		$.get("ajax.php",{'action':'edit','id':currentTODO.data('id'),'text':text});
		$.post("ajaxedit",{'id':currentTODO.data('id'),'name':text});
		
		currentTODO.removeData('origText')
					.find(".text")
					.text(text);
	});
	
	
	// The Add New ToDo button:
	
	var timestamp=0;
	$('#addButton').click(function(e){

		// $.get("ajax.php",{'action':'new','text':'New Todo Item. Doubleclick to Edit.','rand':Math.random()},function(msg){
		$.post("ajaxadd",{'name':'New Todo Item. Doubleclick to Edit.'},function(msg){

			// Appending the new todo and fading it into view:
			$(msg).hide().prependTo('.todoList').fadeIn();
		});

		
		e.preventDefault();
	});

    $("input[type=text]").keydown(function (e) { 
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });
});