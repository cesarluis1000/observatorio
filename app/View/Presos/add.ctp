<fieldset>
	<legend><?php echo __('Registrar Preso'); ?></legend>
	<?php echo $this->Form->create('Preso', array('class' => 'form-horizontal',
		'inputDefaults'=>array('div' => array('class' => 'form-group'),'between' => '<div class="col-sm-6">','after' => '</div>','class'=>'form-control input-xs','error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))))); ?>
		<?php
		echo $this->Form->input('app',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('apm',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('nombre',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('doc_ident',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('tipo_documento_id',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('fecha_ingreso',array('label'=>array('class'=>'control-label col-sm-2'),'type' => 'text','placeholder'=>'YYYY-MM-DD'));
		echo $this->Form->input('nro_ingresos',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('delito_especifico_id',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('sit_juridi',array('label'=>array('class'=>'control-label col-sm-2'),'options'=> $sit_juridi,'empty' => 'Seleccionar'));
		echo $this->Form->input('pena_impuesta_an',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('pena_impuesta_meses',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('mot_ingreso',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('origen_penitenciario_id',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('fecha_nac',array('label'=>array('class'=>'control-label col-sm-2'),'type' => 'text','placeholder'=>'YYYY-MM-DD'));
		echo $this->Form->input('edad',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('sexo',array('label'=>array('class'=>'control-label col-sm-2'),'options'=> $a_sexos,'empty' => 'Seleccionar'));
		echo $this->Form->input('nacionalidad',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('nomb_padre',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('app_padre',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('apm_padre',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('nomb_madre',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('app_madre',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('apm_madre',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('estab_penitenciario_id',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('creador',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('creado',array('label'=>array('class'=>'control-label col-sm-2'),'type' => 'text','placeholder'=>'YYYY-MM-DD HH:mm:ss'));
		echo $this->Form->input('modificador',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('modificado',array('label'=>array('class'=>'control-label col-sm-2'),'type' => 'text','placeholder'=>'YYYY-MM-DD HH:mm:ss'));

	?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
					<?php echo $this->Form->button('Guardar', array('type' => 'submit','class'=>'btn btn-success'));  ?>
		</div>
	</div>
		<?php echo $this->Form->end(); ?>
</fieldset>
