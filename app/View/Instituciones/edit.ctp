<fieldset>
	<legend><?php echo __('Edit Institucion'); ?></legend>
	<?php echo $this->Form->create('Institucion', array('class' => 'form-horizontal',
		'inputDefaults'=>array('div' => array('class' => 'form-group'),'between' => '<div class="col-sm-6">','after' => '</div>','class'=>'form-control input-xs','error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))))); ?>
		<?php
		echo $this->Form->input('id',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('nombre',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('ubicacion',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('latitud',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('longitud',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('estado',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('distrito_id',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('tipo_institucion_id',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('creador',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('creado',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('modificador',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('modificado',array('label'=>array('class'=>'control-label col-sm-2')));
	?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
					<?php echo $this->Form->button('Guardar', array('type' => 'submit','class'=>'btn btn-success'));  ?>
		</div>
	</div>
		<?php echo $this->Form->end(); ?>
</fieldset>