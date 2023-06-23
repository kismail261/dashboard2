$(function (e) {

	// Message
	$("#but1").click(function () {
		$('body').removeClass('timer-alert');
		var message = $("#message").val();
		if (message == "") {
			message = "Your message";
		}
		swal(message);
	});

	// With message and title
	$("#but2").click(function () {
		var message = $("#message").val();
		$('body').removeClass('timer-alert');
		var title = $("#title").val();
		if (message == "") {
			message = "Your message";
		}
		if (title == "") {
			console.log('ok')
			title = "Your message";
		}
		swal(title, message);
	});

	// Show image
	$("#but3").click(function () {
		var message = $("#message").val();
		$('body').removeClass('timer-alert');
		var title = $("#title").val();
		if (message == "") {
			message = "Your message";
		}
		if (title == "") {
			title = "Your message";
		}
		swal({
			title: title,
			text: message,
			imageUrl: '../assets/img/brand/favicon.png'
		});
	});

	// Timer
	$("#but4").click(function () {
		var message = $("#message").val();
		$('body').addClass('timer-alert');
		var title = $("#title").val();
		if (message == "") {
			message = "Your message";
		}
		if (title == "") {
			title = "Your message";
		}
		message += "(close after 2 seconds)";
		swal({
			title: title,
			text: message,
			timer: 2000,
			showConfirmButton: false
		});
	});


	//Basic
	$('#swal-basic').on('click', function () {
		$('body').removeClass('timer-alert');
		swal('Welcome to Your Admin Page')
	});

	//A title with a text under
	$('#swal-title').click(function () {
		$('body').removeClass('timer-alert');
		swal(
			{
				title: 'Here is  a title!',
				text: 'All are available in the template',
			}
		)
	});

	//Success Message
	$('#swal-success').click(function () {
		$('body').removeClass('timer-alert');
		swal(
			{
				title: 'Well done!',
				text: 'You clicked the button!',
				type: 'success',
				confirmButtonColor: '#57a94f'
			}
		)
	});

	//Warning Message
	$('#swal-warning').click(function () {
		$('body').removeClass('timer-alert');
		swal({
			title: "Are you sure?",
			text: "Your will not be able to recover this imaginary file!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn btn-danger",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false
		},
			function () {
				swal("Deleted!", "Your imaginary file has been deleted.", "success");
			});
	});

	//Parameter
	$('#swal-parameter').click(function () {
		$('body').removeClass('timer-alert');
		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this imaginary file!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
			function (isConfirm) {
				if (isConfirm) {
					swal("Deleted!", "Your imaginary file has been deleted.", "success");
				} else {
					swal("Cancelled", "Your imaginary file is safe :)", "error");
				}
			});
	});

	//Custom Image
	$('#swal-image').click(function () {
		$('body').removeClass('timer-alert');
		swal({
			title: 'Lovely!',
			text: 'your image is uploaded.',
			imageUrl: '../assets/img/faces/11.jpg',
			animation: false,
		})
	});

	//Auto Close Timer
	$('#swal-timer').click(function () {
		$('body').removeClass('timer-alert');
		swal({
			title: 'Auto close alert!',
			text: 'I will close in 1 seconds.',
			timer: 1000
		})?.then(
			function () {
			},
			// handling the promise rejection
			function (dismiss) {
				if (dismiss === 'timer') {
					console.log('I was closed by the timer')
				}
			}
		)
	});

	//Ajax with Loader Alert
	$('#swal-ajax').click(function () {
		$('body').removeClass('timer-alert');
		swal({
			title: "Ajax request example",
			text: "Submit to run ajax request",
			type: "info",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		}, function () {
			setTimeout(function () {
				swal("Ajax request finished!");
			}, 2000);
		});
	});

});