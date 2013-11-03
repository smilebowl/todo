//$(document).ready(function($){
$(function(){
	$.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
    $('.dateEditable').datepicker({
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
		showButtonPanel: true,
//		changeMonth: true,
        showAnim: 'show'
    });
    $('.ui-datepicker').hide();
});
