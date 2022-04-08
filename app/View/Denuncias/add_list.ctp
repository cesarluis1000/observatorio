<fieldset>
	<legend><?php echo __('Agregar lista de denuncias'); ?></legend>
	<?php echo $this->Form->create('Denuncia', array('class' => 'form-horizontal',
		'inputDefaults'=>array('div' => array('class' => 'form-group'),'between' => '<div class="col-sm-6">','after' => '</div>','class'=>'form-control input-xs','error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))))); ?>
		<?php
		echo $this->Form->input('denuncias',array('type'=>'textarea', 'escape' => false, 'required' => true, 'label'=>array('class'=>'control-label col-sm-2 required'), 'rows' => '10', 'cols' => '20'));
	?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
					<?php echo $this->Form->button('Guardar', array('type' => 'submit','class'=>'btn btn-success'));  ?>
		</div>
	</div>
		<?php echo $this->Form->end(); ?>
</fieldset>
