    <div class="row">
    
    	<div class="col-md-2">
				 <legend><?php echo __('Cuadro de Delito'); ?></legend>
                 <?php
                            
                    echo $this->Form->create('Reportes', array(
                                'class' => 'form-horizontal',
                                'type' => 'get',
                                'inputDefaults' => array(
                                    'div' => array(
                                        'class' => 'form-group'
                                    ),
                                    'between' => '<div class="col-sm-8">',
                                    'after' => '</div>',
                                    'class' => 'form-control input-xs',
                                    'error' => array(
                                        'attributes' => array(
                                            'wrap' => 'span',
                                            'class' => 'help-inline'
                                        )
                                    )
                                )
                            ));
                            ?>
                <?php echo $this->Form->input('departamento_id',array('label'=>array('class'=>'control-label col-sm-4'),'options'=> $departamentos,'empty' => 'Seleccionar')); ?>
                <?php echo $this->Form->input('provincia_id',array('label'=>array('class'=>'control-label col-sm-4'),'options'=> $provincias,'empty' => 'Seleccionar')); ?>
                <?php echo $this->Form->input('distrito_id',array('label'=>array('class'=>'control-label col-sm-4'),'options'=> $distritos,'empty' => 'Seleccionar')); ?>

				
                <div id="slider-range"></div>
                <br/>
                <?php if (isset($distrito) && !empty($distrito)){ ?>                    
                <fieldset>
                	<legend><?php echo $distrito['Distrito']['nombdist'] ?></legend>
                	<ul>
                		<li>Area: <?php echo $distrito['Distrito']['area_minam'] ?> Km2.</li>
                		<li>Población en miles: <?php echo $distrito['Distrito']['poblacion'] ?></li>
                	</ul>
                </fieldset>
                <?php } ?>               
                
                <div class="form-group">
    				<div class="col-sm-12 text-right">
                		<?php echo $this->Form->button('Buscar', array('type' => 'submit','class'=>'btn btn-primary btn-xs'));  ?>
                	</div>
    			</div>
    			
            	<?php echo $this->Form->end(); ?>
            	<br/>          	
			            	

              
    	</div>
   
    
    	<div class="col-md-10">
        	<div style="width:95%;">
        		<canvas id="canvas"></canvas>
        	</div>        	
    	</div>
    	
    </div>
	
<?php 
echo $this->Html->script('cuadro_distritos.js');
?>
<script>
$(function(){
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
});	
</script>