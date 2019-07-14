<fieldset>
	<legend><?php echo __('Add Denuncia'); ?></legend>
	<?php echo $this->Form->create('Denuncia', array('class' => 'form-horizontal',
		'inputDefaults'=>array('div' => array('class' => 'form-group'),'between' => '<div class="col-sm-6">','after' => '</div>','class'=>'form-control input-xs','error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))))); ?>
		<?php
		echo $this->Form->input('nro_denuncia',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('categoria',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('distrito_id',array('label'=>array('class'=>'control-label col-sm-2'),'empty' => 'Seleccionar'));
		echo $this->Form->input('horizontal',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('vertical',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('ubicacion',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('ubicacion2',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('fecha_hecho',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('fecha_registro',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('comiseria',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('estado',array('label'=>array('class'=>'control-label col-sm-2'),'options'=> $a_estados,'empty' => 'Seleccionar'));
	?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
					<?php echo $this->Form->button('Guardar', array('type' => 'submit','class'=>'btn btn-success'));  ?>
		</div>
	</div>
		<?php echo $this->Form->end(); ?>
</fieldset>