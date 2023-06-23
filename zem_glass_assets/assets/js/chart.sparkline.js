$(function() {
	'use strict'
	
	/***************** LINE CHARTS *****************/
	$('#sparkline1').sparkline('html', {
		width: 200,
		height: 70,
		lineColor: '#4fb7e3',
		fillColor: false,
	});
	$('#sparkline2').sparkline('html', {
		width: 200,
		height: 70,
		lineColor: '#ffda82',
		fillColor: false
	});
	$('#sparkline11').sparkline('html', {
		width: 200,
		height: 70,
		lineColor: '#fd9caf',
		fillColor: false,
	});
	/************** AREA CHARTS ********************/
	$('#sparkline3').sparkline('html', {
		width: 200,
		height: 70,
		lineColor: '#4fb7e3',
		fillColor: 'rgba(79, 183, 227, 0.2)',
	});
	$('#sparkline4').sparkline('html', {
		width: 200,
		height: 70,
		lineColor: '#ffda82',
		fillColor: 'rgba(255, 218, 130, 0.2)'
	});
	$('#sparkline14').sparkline('html', {
		width: 200,
		height: 70,
		lineColor: '#fd9caf',
		fillColor: 'rgba(253, 156, 175, 0.2)'
	});
	/******************* BAR CHARTS *****************/
	$('#sparkline5').sparkline('html', {
		type: 'bar',
		barWidth: 10,
		height: 70,
		barColor: '#4fb7e3',
		chartRangeMax: 12
	});
	$('#sparkline6').sparkline('html', {
		type: 'bar',
		barWidth: 10,
		height: 70,
		barColor: '#ffda82',
		chartRangeMax: 12
	});
	$('#sparkline16').sparkline('html', {
		type: 'bar',
		barWidth: 10,
		height: 70,
		barColor: '#fd9caf',
		chartRangeMax: 12
	});
	/***************** STACKED BAR CHARTS ****************/
	$('#sparkline7').sparkline('html', {
		type: 'bar',
		barWidth: 10,
		height: 70,
		barColor: '#ffda82',
		chartRangeMax: 12
	});
	$('#sparkline7').sparkline([4, 5, 6, 7, 4, 5, 8, 7, 6, 6, 4, 7, 6, 4, 7], {
		composite: true,
		type: 'bar',
		barWidth: 10,
		height: 70,
		barColor: '#4fb7e3',
		chartRangeMax: 12
	});
	$('#sparkline8').sparkline('html', {
		type: 'bar',
		barWidth: 10,
		height: 70,
		barColor: '#7891ef',
		chartRangeMax: 12
	});
	$('#sparkline8').sparkline([4, 5, 6, 7, 4, 5, 8, 7, 6, 6, 4, 7, 6, 4, 7], {
		composite: true,
		type: 'bar',
		barWidth: 10,
		height: 70,
		barColor: '#4ac9bd ',
		chartRangeMax: 12
	});
	$('#sparkline18').sparkline('html', {
		type: 'bar',
		barWidth: 10,
		height: 70,
		barColor: '#ffa961',
		chartRangeMax: 12
	});
	$('#sparkline18').sparkline([4, 5, 6, 7, 4, 5, 8, 7, 6, 6, 4, 7, 6, 4, 7], {
		composite: true,
		type: 'bar',
		barWidth: 10,
		height: 70,
		barColor: '#8b89d6',
		chartRangeMax: 12
	});
	/**************** PIE CHART ****************/
	$('#sparkline9').sparkline('html', {
		type: 'pie',
		width: 70,
		height: 70,
		sliceColors: ['#4fb7e3', '#ffda82', '#2dce89']
	});
	$('#sparkline10').sparkline('html', {
		type: 'pie',
		width: 70,
		height: 70,
		sliceColors: ['#4fb7e3', '#ffda82', '#2dce89']
	});
	$('#sparkline01').sparkline('html', {
		type: 'pie',
		width: 70,
		height: 70,
		sliceColors: ['#4fb7e3',  '#2dce89','#ffc107','#3db4ec','#dc3545','#ffda82']
	});
	$('#sparkline02').sparkline('html', {
		type: 'pie',
		width: 70,
		height: 70,
		sliceColors: ['#fd9caf', '#ffda82', '#2dce89','#4ac9bd ','#ffc107','#fd9caf','#dc3545']
	});
});