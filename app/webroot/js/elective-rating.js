$(document).ready(function(){
	var choices = new Array();
	$('.checkbox').click(function(){
		var selected_boxes = $('.checkbox:checked').length;
		var id = $(this)[0].id.split('cb')[1];
		var selectBox = $('#s' + id);
		if ( selectBox.attr('disabled') ) {
			selectBox.attr('disabled', false);
		} else {
			selectBox.attr('disabled', true);
		}
		$('.selectbox').each(function(i){
			if ( !$('#s' + (i+1)).attr('disabled') ) {
				$(this).empty();
				for ( i = 0 ; i < selected_boxes ; i++ ) {
					$(this).append($('<option value="' + (i+1) + '">' + (i+1) + '</option>'));
				}
			}
		});
	});
	$('.selectbox').change(function(){
		
		var current = $(this);
		if ( current.attr('style') ) {
			$('.selectbox').removeAttr('style');
		}
		$('.selectbox').each(function(){
			if ($(this).val() == current.val() && $(this).attr('id') != current.attr('id')) {
				$(this).css('background', 'red');
				current.css('background', 'red');
			}
		});
	});
});
