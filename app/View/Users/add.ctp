<fieldset>
	<legend><?php echo __('Add User'); ?></legend>
	<?php echo $this->Form->create('User', array('class' => 'form-horizontal',
		'inputDefaults'=>array('div' => array('class' => 'form-group'),'between' => '<div class="col-sm-6">','after' => '</div>','class'=>'form-control input-xs','error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))))); ?>
		<?php
		echo $this->Form->input('nombres',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('app',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('apm',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('correo',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('username',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('password',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('group_id',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('estado',array('label'=>array('class'=>'control-label col-sm-2'),'options'=> $a_estados,'empty' => 'Seleccionar'));
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