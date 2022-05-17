

var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
var randomScalingFactor = function() {
    return Math.round(Math.random() * 100);
};

var delito_generico_id = $('#ReportesDelitoGenericoId option:selected').val();
var delito_especifico_id = $('#ReportesDelitoEspecificoId option:selected').val();
var sit_juridi = $('#ReportesSitJuridi option:selected').val();
var base  = $('base').attr('href');
var url   = base+'DelitoEspecificos/presoschartjs?delito_generico_id='+delito_generico_id+'&delito_especifico_id='+delito_especifico_id+'&sit_juridi='+sit_juridi;


$.ajax({
	url : url,
	dataType : 'json',
	async : false,
}).done(function(data) {
	config = data;
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


window.onload = function() {
	var ctx = document.getElementById('canvas').getContext('2d');
	window.myLine = new Chart(ctx, config);
};
