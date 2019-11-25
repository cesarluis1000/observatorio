$(function(){
	
    
    //$(".contenedor--menu").hide();

    $(".icono").click(function () {
        $(".contenedor--menu").animate({width: "toggle"});
        event.preventDefault();
        //elem.slideToggle();
    });
	
	var base = $('base').attr('href');
	$('#ReportesDepartamentoId').click(function(){
		var departamento_id = $(this).val();		
		if (departamento_id !== '' && departamento_id !== undefined) {
			$.ajax({
				url: base+'/Provincias/listjson?departamento_id='+departamento_id,
				dataType: 'json',
			    async: false,
			}).done(function(data){				
				var len = data.length;
				$('#ReportesProvinciaId').empty();
				$("#ReportesProvinciaId").append("<option value=''>Seleccionar</option>");
				for(var i=0; i<len; i++){
					var id = data[i]['Provincia']['id'];	
					var name = data[i]['Provincia']['nombprov'];
					$("#ReportesProvinciaId").append("<option value='"+id+"'>"+name+"</option>");
				}
			});
		}		
	})
	
	$('#ReportesProvinciaId').click(function(){
		var provincia_id = $(this).val();
		if (provincia_id !== '' && provincia_id !== undefined) {
			$.ajax({
				url: base+'/Distritos/listjson?provincia_id='+provincia_id,
				dataType: 'json',
			    async: false,
			}).done(function(data){				
				var len = data.length;
				$('#ReportesDistritoId').empty();
				$("#ReportesDistritoId").append("<option value=''>Seleccionar</option>");
				for(var i=0; i<len; i++){
					var id = data[i]['Distrito']['id'];	
					var name = data[i]['Distrito']['nombdist'];
					$("#ReportesDistritoId").append("<option value='"+id+"'>"+name+"</option>");
				}
			});
		}
	});
	
	$('#ReportesDepartamentoId, #ReportesProvinciaId, #ReportesDistritoId').change(function(){
		$('#ReportesGhostZoom').val('');
		$('#ReportesCentroZoom').val('');
	})
	
	/*******Filtro Horas******/
	
    $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: 1440,
        step: 60,
        values: [ $('#ReportesHoras1').val()*60 , $('#ReportesHoras2').val()*60 ], //or whatever default time you want
        slide: function( event, ui ) {
      	  var hours1 = Math.floor(ui.values[0] / 60);
            var minutes1 = ui.values[0] - (hours1 * 60);

            if(hours1.length == 1) hours1 = '0' + hours1;
            if(minutes1.length == 1) minutes1 = '0' + minutes1;
            if(minutes1 == 0) minutes1 = '00';

            if(hours1 >= 12){

                if (hours1 == 12){
                    hours1 = hours1;
                    minutes1 = minutes1 + " PM";
                }
                else{
                    hours1 = hours1 - 12;
                    minutes1 = minutes1 + " PM";
                }
            }

            else{

                hours1 = hours1;
                minutes1 = minutes1 + " AM";
            }
            if (hours1 == 0){
                hours1 = 12;
                minutes1 = minutes1;
            }
            var hours2 = Math.floor(ui.values[1] / 60);
            var minutes2 = ui.values[1] - (hours2 * 60);

            if(hours2.length == 1) hours2 = '0' + hours2;
            if(minutes2.length == 1) minutes2 = '0' + minutes2;
            if(minutes2 == 0) minutes2 = '00';
            if(hours2 >= 12){
                if (hours2 == 12){
                    hours2 = hours2;
                    minutes2 = minutes2 + " PM";
                }
                else if (hours2 == 24){
                    hours2 = 11;
                    minutes2 = "59 PM";
                }
                else{
                    hours2 = hours2 - 12;
                    minutes2 = minutes2 + " PM";
                }
            }
            else{
                hours2 = hours2;
                minutes2 = minutes2 + " AM";
            }

            $( "#ReportesHoras" ).val(  hours1 +':'+minutes1 + " - " + hours2+':'+minutes2 );
        }
      });
    
    /******Check de Delitos*****/
    $('.form-check-all').click(function(){
    	if( $('#ckdAll').is(':checked') ){
    		$('.form-check input').prop('checked', true);
    	}else{
    		$('.form-check input').prop('checked', false);
    	}
    });
});