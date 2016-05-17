$ = jQuery;
$(function(){
	$('#doExport').click(function(event) {
		event.preventDefault();
		var option = $('#exportMethod').val();
		if( option != -1){
			window.location = option
		}
	});
});
