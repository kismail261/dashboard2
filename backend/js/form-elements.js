// Additional code for adding placeholder in search box of select2
(function ($) {
	var Defaults = $.fn.select2.amd.require('select2/defaults');
	$.extend(Defaults.defaults, {
		searchInputPlaceholder: ''
	});
	var SearchDropdown = $.fn.select2.amd.require('select2/dropdown/search');
	var _renderSearchDropdown = SearchDropdown.prototype.render;
	SearchDropdown.prototype.render = function (decorated) {
		// invoke parent method
		var $rendered = _renderSearchDropdown.apply(this, Array.prototype.slice.apply(arguments));
		this.$search.attr('placeholder', this.options.get('searchInputPlaceholder'));
		return $rendered;
	};
})(window.jQuery);
$(function () {
	'use strict'
	// Toggle Switches
	$('.main-toggle').on('click', function () {
		$(this).toggleClass('on');
	})
	// Input Masks
	$('#dateMask').mask('99/99/9999');
	$('#phoneMask').mask('(999) 999-9999');
	$('#phoneExtMask').mask('(999) 999-9999? ext 99999');
	$('#ssnMask').mask('999-99-9999');
});

// Filebrowser
$(document).on('change', ':file', function () {
	var input = $(this),
		numFiles = input.get(0).files ? input.get(0).files.length : 1,
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	input.trigger('fileselect', [numFiles, label]);
});

// We can watch for our custom `fileselect` event like this
$(document).ready(function () {
	$(':file').on('fileselect', function (event, numFiles, label) {

		var input = $(this).parents('.input-group').find(':text'),
			log = numFiles > 1 ? numFiles + ' files selected' : label;

		if (input.length) {
			input.val(log);
		} else {
			if (log) { };
		}
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
	$('.select2').on('click', () => {
		let selectField = document.querySelectorAll('.select2-search__field')
		selectField.forEach((element, index) => {
			element?.focus();
		})
	});

	//select2 style-01
	function select2Img(data) {
		if (!data.id) { return data.text; }
		var $data = $(
			'<span class="d-flex align-items-center"><img src="../assets/img/faces/' + data.element.value.toLowerCase() + '.jpg" class="rounded-circle avatar-xs me-1" /> '
			+ data.text + '</span>'
		);
		return $data;
	};

	$(".select2-img").select2({
		templateResult: select2Img,
		templateSelection: select2Img,
		escapeMarkup: function (m) { return m; }
	});
});
