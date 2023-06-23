//Sales Chart
var options = {
	series: [{
		name: 'Orders',
		type: 'column',
		data: [1.8, 2.5, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6]
	}, {
		name: 'Sales',
		type: 'column',
		data: [1.1, 2.2, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
	}, {
		name: 'Profit',
		type: 'line',
		data: [20, 29, 37, 35, 44, 43, 50, 58],
	},
	],
	chart: {
		height: 350,
		type: 'line',
        fontFamily: 'poppins, sans-serif',
		stacked: false
	},
	grid: {
		borderColor: '#f2f6f7',
	},
	dataLabels: {
		enabled: false
	},
	stroke: {
		width: [1, 1, 4],
	},
	title: {
		text: undefined,
		align: 'left',
		offsetX: 110
	},
	xaxis: {
		categories: [2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022],
		axisBorder: {
			color: 'rgba(119, 119, 142, 0.05)',
			offsetX: 0,
			offsetY: 0,
		},
		axisTicks: {
			color: 'rgba(119, 119, 142, 0.05)',
			width: 6,
			offsetX: 0,
			offsetY: 0
		},
	},
	yaxis: [
		{
			show: true,
			axisTicks: {
				show: true,
			},
			axisBorder: {
				show: false,
				color: '#4eb6d0'
			},
			labels: {
				style: {
					colors: '#4eb6d0',
				}
			},
			title: {
				text: undefined,
				style: {
					color: '#4eb6d0',
				}
			},
			tooltip: {
				enabled: true
			}
		},
		{
			seriesName: 'Orders',
			opposite: true,
			axisTicks: {
				show: true,
			},
			axisBorder: {
				show: false,
				color: '#00E396'
			},
			labels: {
				style: {
					colors: '#00E396',
				}
			},
			title: {
				text: undefined,
				style: {
					color: '#00E396',
				}
			},
		},
		{
			seriesName: 'Profit',
			opposite: true,
			axisTicks: {
				show: true,
			},
			axisBorder: {
				show: false,
				color: '#000000'
			},
			labels: {
				show: false,
				style: {
					colors: '#FEB019',
				},
			},
			title: {
				text: undefined,
				style: {
					color: '#FEB019',
				}
			}
		},
	],
	tooltip: {
		enabled: true,
	},
	colors: ['000', "#ededed", "#fd7e14"],
	legend: {
		position: 'top',
		offsetX: 40
	}, stroke: {
		width: [0, 0, 1.5],
		curve: 'smooth',
		dashArray: [0, 0, 2],
	},
	plotOptions: {
		bar: {
			columnWidth: "35%",
			borderRadius: 3
		}
	},
};
var chart1 = new ApexCharts(document.querySelector("#chartA"), options);
chart1.render();
function chartA() {
	chart1.updateOptions({
		colors: [`rgb(${myVarVal})`, `rgba(${myVarVal}, 0.4)`, "#fd7e14"],
	})
}

$(function () {
	$('#vmap').vectorMap({
		map: 'world_en',
		scaleColors: ['#e8e8e8', '#ffffff'],
		normalizeFunction: 'polynomial',
		// hoverColor: true,
		hoverColor: '#4eb6d0',
		regionStyle: {
			initial: {
				fill: '#f2f2f2'
			}
		},
		markerStyle: {
			initial: {
				r: 6,
				'fill': '#4ac9bd',
				'fill-opacity': 0.9,
				'stroke': '#fff',
				'stroke-width': 9,
				'stroke-opacity': 0.2
			},
			hover: {
				'stroke': '#fff',
				'fill-opacity': 1,
				'stroke-width': 1.5
			}
		},
		backgroundColor: 'transparent',
		markers: [{
			latLng: [-15.793889, -47.882778],
			name: 'Brazil'
		}, {
			latLng: [-35.473469, 149.012375],
			name: 'Australia'
		}, {
			latLng: [61.5240, 105.3188],
			name: 'Russia'
		},]
	});
})

$(function () {

	// Data Table
	$('#productSummary').DataTable({
		language: {
			searchPlaceholder: 'Search here...',
			sSearch: '',
			lengthMenu: '_MENU_',
		}
	});

	//______Select2
	$('.select2').select2({
		minimumResultsForSearch: Infinity,
		width: "auto"
	});
});
