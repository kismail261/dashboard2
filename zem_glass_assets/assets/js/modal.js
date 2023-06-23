$(function() {
	'use strict'
	
	// __________MODAL
	// showing modal with effect
	$('.modal-effect').on('click', function(e) {
		e.preventDefault();
		var effect = $(this).attr('data-bs-effect');
		$('#effectModal').addClass(effect);
	});
	// hide modal with effect
	$('#effectModal').on('hidden.bs.modal', function(e) {
		$(this).removeClass(function(index, className) {
			return (className.match(/(^|\s)effect-\S+/g) || []).join(' ');
		});
	});

	$('.select2').select2({
		minimumResultsForSearch: Infinity,
		width: '100%'
	});

});