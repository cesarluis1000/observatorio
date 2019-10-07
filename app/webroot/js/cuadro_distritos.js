

var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
var randomScalingFactor = function() {
    return Math.round(Math.random() * 100);
};

var departamento_id = $('#ReportesDepartamentoId option:selected').val();
var provincia_id 	= $('#ReportesProvinciaId option:selected').val();
var distrito_id 	= $('#ReportesDistritoId option:selected').val();
var base  = $('base').attr('href');
var url   = base+'Distritos/delitosgeojson?departamento_id='+departamento_id+'&provincia_id=' + provincia_id + '&distrito_id='+ distrito_id;
$.ajax({
	url : url,
	dataType : 'json',
	async : false,
}).done(function(data) {
	debugger;
	//config = data;
});

var config = {
	type: 'line',
	data: {
		labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September'],
		datasets: [{
			label: 'HURTO',
			backgroundColor: window.chartColors.red,
			borderColor: window.chartColors.red,
			data: [
				881,734,786,670,761,780,669,885,415
			],
			fill: false,
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
		}, {
			label: 'VIOLENCIA SEXUAL',
			fill: false,
			backgroundColor: window.chartColors.green,
			borderColor: window.chartColors.green,
			data: [
				13,22,34,30,35,32,28,36,14
			],
		}, {
			label: 'ESTAFA',
			fill: false,
			backgroundColor: window.chartColors.yellow,
			borderColor: window.chartColors.yellow,
			data: [
				32,33,34,37,43,25,32,36,10
			],
		}, {
			label: 'DROGAS',
			fill: false,
			backgroundColor: window.chartColors.purple,
			borderColor: window.chartColors.purple,
			data: [
				13,6,17,12,15,14,11,15,8
			],
		}, {
			label: 'SECUESTRO',
			fill: false,
			backgroundColor: window.chartColors.yellow,
			borderColor: window.chartColors.yellow,
			data: [
				0,2,0,1,1,3,3,4,0
			],
		}, {
			label: 'HOMICIDIO',
			fill: false,
			backgroundColor: window.chartColors.gray,
			borderColor: window.chartColors.gray,
			data: [
				4,7,3,7,7,4,0,0,0
			],
		}]
	},
	options: {
		responsive: true,
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

window.onload = function() {
	var ctx = document.getElementById('canvas').getContext('2d');
	window.myLine = new Chart(ctx, config);
};