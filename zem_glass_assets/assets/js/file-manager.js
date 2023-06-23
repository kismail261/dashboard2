(function($) {

    //______Basic Data Table
    $('#recentFilesDataTable').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
        }
    });

    //fancyfileuplod
	$('#demo').FancyFileUpload({
		params : {
			action : 'fileuploader'
		},
		maxfilesize : 1000000
	});

    	//______Select2 
	$('.select2').select2({
		minimumResultsForSearch: Infinity,
		width:"auto",
	});

})(jQuery)
