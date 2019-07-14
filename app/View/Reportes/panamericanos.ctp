<?php echo $this->Html->css('jquery-ui.css'); ?>
<?php echo $this->Html->script('jquery-ui.js'); ?>
<?php echo $this->Html->css('layout.css'); ?>
<fieldset>
    
    <div class="row">
    
    	<div class="col-md-2">
    				 <legend><?php echo __('Juegos Panamericanos'); ?></legend>
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
                    <?php echo $this->Form->input('fecha_de',array('label'=>array('class'=>'control-label col-sm-4'),'type' => 'text','placeholder'=>'YYYY-MM-DD')); ?>
                    <?php echo $this->Form->input('hasta',array('label'=>array('class'=>'control-label col-sm-4'),'type' => 'text','placeholder'=>'YYYY-MM-DD')); ?>
                    <?php echo $this->Form->input('horas',array('label'=>array('class'=>'control-label col-sm-4'),'type' => 'text','readonly'=>'readonly')); ?>
                    <?php echo $this->Form->input('horas1',array('type' => 'hidden','value'=>$horas1)); ?>
                    <?php echo $this->Form->input('horas2',array('type' => 'hidden','value'=>$horas2)); ?>
					<?php echo $this->Form->input('ghostZoom',array('type' => 'hidden')); ?>
					<?php echo $this->Form->input('centroZoom',array('type' => 'hidden')); ?>
					
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

					
                    <fieldset>
                    	<legend>Delitos</legend>
                        <div class="form-check-all">
                        	<input type="checkbox" class="form-check-input" name="ckdAll" id="ckdAll" <?php echo $this->request['data']['Reportes']['ckdAll'] ?>>                        
                        	<label class="form-check-label" for="ckdAll">TODO (<?php echo $total ?>)</label>                        	                
                        </div>
                        
                        <?php foreach ($denuncias as $denuncia){ ?>                  	
                            <div class="form-check">
                            	<input type="checkbox" class="form-check-input" name="delito[<?php echo $denuncia['Denuncia']['id'] ?>]" id="<?php echo $denuncia['Denuncia']['id'] ?>" <?php echo $denuncia['Denuncia']['checked'] ?>>                        
                            	<label class="form-check-label" for="<?php echo $denuncia['Denuncia']['id'] ?>"><?php echo $denuncia['Denuncia']['categoria'] ?> (<?php echo $denuncia['Denuncia']['subTotal'] ?>)</label>
                            	<img alt="" src="<?php echo $denuncia['Denuncia']['img'] ?>" style="width: 20px">                                
                            </div>
                        <?php } ?>
                    
                    </fieldset>
                    
                    <div class="form-group">
        				<div class="col-sm-12 text-right">
                    		<?php echo $this->Form->button('Buscar', array('type' => 'submit','class'=>'btn btn-primary btn-xs'));  ?>
                    	</div>
        			</div>      			
        			
                <?php echo $this->Form->end(); ?>
            	<br/>
              
    	</div>
    
    	<div class="col-md-10">
        	<div class="mapcontainer">
        		<div id="map" class="map"></div>

        	</div>
        	<div style="display: none;">
              <!-- Popup -->
              <div id="popup" title="Delito">
              		<a href="#" id="popup-closer" class="ol-popup-closer"></a>
      				<div id="popup-content"></div>
              </div>
            </div>        	
    	</div>
    	
    </div>
</fieldset>

<?php 
echo $this->Html->script('feminicidio.js');
if (!empty($this->request->data['Reportes']['distrito_id'])){
    echo $this->Html->script('mapa_comiserias.js');
}elseif(!empty($distritos)){
    echo $this->Html->script('mapa_distritos.js');
}elseif (!empty($provincias)){
    echo $this->Html->script('mapa_provincias.js');
}else{
    echo $this->Html->script('mapa_peru.js');
}
?>