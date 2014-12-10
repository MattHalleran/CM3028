$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	$('#ajaxModal').on('show.bs.modal', function (event) {
  		var button = $(event.relatedTarget); // Button that triggered the modal
  		var url = button.data('ajax'); // Extract info from data-* attributes
  			// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  		var modal = $(this);
	  modal.find('.modal-title').text(button.data('title'));
	  modal.find('.modal-body').load(url);
	  modal.find('#submit').click(function(){
	  	modal.find('.modal-body form').submit();
	  });
	});
	$('.vote-time .label').dblclick(function(){
		var startVal = $('.vote-time .label.start').html();
		var endVal = $('.vote-time .label.end').html();
		$('.vote-time .label.start').empty().append('<input name="data[start]" type="text" value="' + startVal + '">');
		$('.vote-time .label.end').empty().append('<input name="data[end]" type="text" value="' + endVal + '">');
		var innerHtml = $('.vote-time').html();
		console.log(innerHtml);
		$('.vote-time').html('<form action="' + sysvars + '" method="post">' + innerHtml + '<input type="submit" class="btn btn-primary btn-sm" value="Save"></form>');
	});
});
