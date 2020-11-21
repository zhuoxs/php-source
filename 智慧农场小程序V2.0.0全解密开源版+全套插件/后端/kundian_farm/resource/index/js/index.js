var ctx = document.getElementById("chart-area").getContext('2d');
var myDoughnut = new Chart(ctx, {
    type: 'doughnut',
	data: {
		datasets: [{
			data: [90,40,10],
			backgroundColor: [
				window.chartColors.red,
				window.chartColors.orange,
				window.chartColors.yellow,
			],
			label: 'Dataset 1'
		}],
		labels: [
			'已完成',
			'待收货',
			'待发货',
		]
	},
	options: {
		responsive: true,
		legend: {
			position: 'right',
		},
		title: {
			display: true,
		},
		animation: {
			animateScale: true,
			animateRotate: true
		}
	}
});