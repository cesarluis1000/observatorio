<fieldset>
	<legend><?php echo __('Edit Departamento'); ?></legend>
	<?php echo $this->Form->create('Departamento', array('class' => 'form-horizontal',
		'inputDefaults'=>array('div' => array('class' => 'form-group'),'between' => '<div class="col-sm-6">','after' => '</div>','class'=>'form-control input-xs','error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))))); ?>
		<?php
		echo $this->Form->input('id',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('first_iddp',array('label'=>array('class'=>'control-label col-sm-2'),'empty' => 'Seleccionar'));
		echo $this->Form->input('nombdep',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('count',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('hectares',array('label'=>array('class'=>'control-label col-sm-2')));
	?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
					<?php echo $this->Form->button('Guardar', array('type' => 'submit','class'=>'btn btn-success'));  ?>
		</div>
	</div>
		<?php echo $this->Form->end(); ?>
</fieldset>