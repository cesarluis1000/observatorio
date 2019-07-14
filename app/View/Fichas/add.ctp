<fieldset>
	<legend><?php echo __('Nueva Ficha de Identificación'); ?></legend>
	<?php echo $this->Form->create('Ficha', array('class' => 'form-horizontal',
		'inputDefaults'=>array('div' => array('class' => 'form-group'),'between' => '<div class="col-sm-6">','after' => '</div>','class'=>'form-control input-xs','error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))))); ?>
		<?php
		echo $this->Form->input('nif',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('sede',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('app',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('apm',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('nombres',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('edad_real',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('edad_aparente',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('iris',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('boca',array('label'=>array('class'=>'control-label col-sm-2'),'options'=> $a_boca,'empty' => 'Seleccionar'));
		echo $this->Form->input('talla',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('nariz',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('labios',array('label'=>array('class'=>'control-label col-sm-2'),'options'=> $a_labios,'empty' => 'Seleccionar'));
		echo $this->Form->input('peso',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('oreja',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('sexo',array('label'=>array('class'=>'control-label col-sm-2'),'options'=> $a_sexo,'empty' => 'Seleccionar'));
		echo $this->Form->input('complexion',array('label'=>array('class'=>'control-label col-sm-2'),'options'=> $a_compexion,'empty' => 'Seleccionar'));
		echo $this->Form->input('fecha_nacimiento',array('label'=>array('class'=>'control-label col-sm-2'),'type' => 'text','placeholder'=>'YYYY-MM-DD'));
		echo $this->Form->input('caracteristicas',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('senias_particulares',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('senias_particulares2',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('senias_particulares3',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('lugar_resenia',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('foto_frente',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('perfil_derecho',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('formula_dactiloscopica',array('label'=>array('class'=>'control-label col-sm-2')));
	?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
					<?php echo $this->Form->button('Guardar', array('type' => 'submit','class'=>'btn btn-success'));  ?>
		</div>
	</div>
		<?php echo $this->Form->end(); ?>
</fieldset>