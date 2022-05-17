    <div class="row">

    	<div class="col-md-2">
				 <legend><?php echo __('Cuadro de Presos'); ?></legend>
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
                <?php echo $this->Form->input('delito_generico_id',array('label'=>array('class'=>'control-label col-sm-4'),'options'=> $de_genericos,'empty' => 'Seleccionar')); ?>
                <?php echo $this->Form->input('delito_especifico_id',array('label'=>array('class'=>'control-label col-sm-4'),'options'=> $de_especificos,'empty' => 'Seleccionar')); ?>
				<?php echo $this->Form->input('sit_juridi',array('label'=>array('class'=>'control-label col-sm-4'),'options'=> $sit_juridi,'empty' => 'Seleccionar')); ?>
				<?php //echo $this->Form->input('sexo',array('label'=>array('class'=>'control-label col-sm-4'),'options'=> $a_sexos,'empty' => 'Seleccionar')); ?>
				<?php echo $this->Form->input('fecha_ingreso',array('label'=>array('class'=>'control-label col-sm-4'),'type' => 'text','placeholder'=>'YYYY-MM-DD')); ?>



                <div id="slider-range"></div>
                <br/>


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
echo $this->Html->script('cuadro_presos.js');
?>
<script>
$(function(){
	var base = $('base').attr('href');
	$('#ReportesDelitoGenericoId').click(function(){
		var delito_generico_id = $(this).val();
		if (delito_generico_id !== '' && delito_generico_id !== undefined) {
			$.ajax({
				url: base+'/DelitoEspecificos/listjson?delito_generico_id='+delito_generico_id,
				dataType: 'json',
			    async: false,
			}).done(function(data){
				var len = data.length;
				$('#ReportesDelitoEspecificoId').empty();
				$("#ReportesDelitoEspecificoId").append("<option value=''>Seleccionar</option>");
				for(var i=0; i<len; i++){
					var id = data[i]['DelitoEspecifico']['id'];
					var name = data[i]['DelitoEspecifico']['nombre'];
					$("#ReportesDelitoEspecificoId").append("<option value='"+id+"'>"+name+"</option>");
				}
			});
		}
	})

	$('#ReportesDelitoEspecificoId').click(function(){
		var delito_especifico_id = $(this).val();
		if (delito_especifico_id !== '' && delito_especifico_id !== undefined) {
			$.ajax({
				url: base+'/DelitoEspecificos/listjson?delito_especifico_id='+delito_especifico_id,
				dataType: 'json',
			    async: false,
			}).done(function(data){

			});
		}
	});

	$('#ReportesSitJuridi').click(function(){
		var sit_juridi = $(this).val();
		if (sit_juridi !== '' && sit_juridi !== undefined) {
			$.ajax({
				url: base+'/DelitoEspecificos/listjson?sit_juridi='+sit_juridi,
				dataType: 'json',
			    async: false,
			}).done(function(data){

			});
		}
	});

});
</script>
