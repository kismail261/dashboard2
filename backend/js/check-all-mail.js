 $(function() {
 	'use strict'
 	$('#checkAll').on('click', function() {
 		if ($(this).is(':checked')) {
 			$('.main-mail-group .ckbox input').each(function() {
 				$(this).closest('.list-group-item').addClass('selected');
 				$(this).attr('checked', true);
 			});
 			$('.main-mail-options .btn').removeClass('disabled');
 		} else {
 			$('.main-mail-group .ckbox input').each(function() {
 				$(this).closest('.list-group-item').removeClass('selected');
 				$(this).attr('checked', false);
 			});
 			$('.main-mail-options .btn').addClass('disabled');
 		}
 	});
 	$('.list-group-item .ckbox input').on('click', function() {
 		if ($(this).is(':checked')) {
 			$(this).attr('checked', false);
 			$(this).closest('.list-group-item').addClass('selected');
 			$('.main-mail-options .btn').removeClass('disabled');
 		} else {
 			$(this).attr('checked', true);
 			$(this).closest('.list-group-item').removeClass('selected');
 			if (!$('.main-mail-group .selected').length) {
 				$('.main-mail-options .btn').addClass('disabled');
 			}
 		}
 	});
 	$('.main-mail-star').on('click', function(e) {
 		$(this).toggleClass('active');
 	});
 });