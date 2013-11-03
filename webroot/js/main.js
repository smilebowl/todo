$(document).ready(function($){
    $('.dateEditable').datepicker({
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
        showAnim: 'show'
    });
    $('.ui-datepicker').hide();
});
