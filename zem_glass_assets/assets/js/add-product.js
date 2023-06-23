(function($) {

    //fancyfileuplod
	$('#productImage').FancyFileUpload({
		params : {
			action : 'fileuploader'
		},
		maxfilesize : 1000000
	});

    //select2
	$('.select2').select2({
		placeholder: 'Choose one',
		searchInputPlaceholder: 'Search'
	});
	$('.select2-no-search').select2({
		minimumResultsForSearch: Infinity,
		placeholder: 'Choose one'
	});

	// Date Picker
	flatpickr("#sheduledDate", {});

})(jQuery)