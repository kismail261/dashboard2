$(function() {
	'use strict';

    var todoChart = document.getElementById('todoChart');
	new Chart(todoChart, {
		type: 'bar',
		data: {
			labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
			datasets: [{
                label: 'Completed',
                barPercentage: 0.3,
				data: [25, 24, 18, 25, 20, 18, 24],
				backgroundColor: '#4fb7e3',
				borderWidth: 1,
				fill: true
			}, {
                label: 'Created',
                barPercentage: 0.3,
				data: [15, 16, 20, 25, 25, 30, 26],
				backgroundColor: '#4ac9bd',
				borderWidth: 1,
				fill: true
			}]
		},
		options: {
			maintainAspectRatio: false,
			legend: {
				display: false,
				labels: {
					display: false
				}
			},
			scales: {
				yAxes: {
					stacked: true,
					ticks: {
						beginAtZero: true,
						fontSize: 11,
						fontColor: "rgba(171, 167, 167,0.9)",
					},
					gridLines: {
						display: false,
						color: 'rgba(171, 167, 167,0.2)',
						drawBorder: false
					},
				},
				xAxes: {
					stacked: true,
					ticks: {
						fontSize: 11,
						fontColor: "rgba(171, 167, 167, 0.9)",
					},
					gridLines: {
						display: true,
						color: 'rgba(171, 167, 167, 0.2)',
						drawBorder: false
					},
				}
			}
		}
	});

    // Active members Data Table
	$('#activeMembers').DataTable({
        responsive: true,
		sLengthMenu:"_MENU_",
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
        }
    });
	$('#todoFiles').DataTable({
        responsive: true,
		sLengthMenu:"_MENU_",
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
        }
    });

	// Select2 
		$('.select2').select2({
		minimumResultsForSearch: Infinity,
		width:"auto",
	});

	// Bootstrap Date Pickers
	flatpickr("#fromDate", {});
	flatpickr("#toDate", {});
});