

var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
var randomScalingFactor = function() {
    return Math.round(Math.random() * 100);
};

var departamento_id = $('#ReportesDepartamentoId option:selected').val();
var provincia_id 	= $('#ReportesProvinciaId option:selected').val();
var distrito_id 	= $('#ReportesDistritoId option:selected').val();
var base  = $('base').attr('href');
var url   = base+'Distritos/delitoschartjs?departamento_id='+departamento_id+'&provincia_id=' + provincia_id + '&distrito_id='+ distrito_id;
$.ajax({
	url : url,
	dataType : 'json',
	async : false,
}).done(function(data) {	
	config = data;
	console.info(config);
});

var config2 = {
	type: 'line',
	data: {
		labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September'],
		datasets: [{
			label: 'HURTO',
			fill: false,
			backgroundColor: window.chartColors.red,
			borderColor: window.chartColors.red,
			data: [
				881,734,786,670,761,780,669,885,415
			],			
		}, {
			label: 'LESIONES',
			fill: false,
			backgroundColor: window.chartColors.blue,
			borderColor: window.chartColors.blue,
			data: [
				117,58,115,85,110,82,62,87,41
			],
		}, {
			label: 'ROBO',
			fill: false,
			backgroundColor: window.chartColors.orange,
			borderColor: window.chartColors.orange,
			data: [
				331,361,314,359,362,273,261,409,177
			],
		}]
	},
	options: {
		responsive: true,
		elements: {
			line: {
				tension: 0.000001
			}
		},
		title: {
					display: true,
					text: 'Distrito Cercado Lima'
				},
		tooltips: {
					mode: 'index',
					intersect: false,
				},
		hover: {
					mode: 'nearest',
					intersect: true
				},
		scales: {
					xAxes: [{
								display: true,
								scaleLabel: {
											display: true,
											labelString: 'Month'
										}
							}],
					yAxes: [{
								display: true,
								scaleLabel: {
											display: true,
											labelString: 'Value'
										}
							}]
		}
	}
};

//console.info(config2);

window.onload = function() {
	var ctx = document.getElementById('canvas').getContext('2d');
	window.myLine = new Chart(ctx, config);
};