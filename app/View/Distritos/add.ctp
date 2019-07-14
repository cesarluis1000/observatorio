<fieldset>
	<legend><?php echo __('Add Distrito'); ?></legend>
	<?php echo $this->Form->create('Distrito', array('class' => 'form-horizontal',
		'inputDefaults'=>array('div' => array('class' => 'form-group'),'between' => '<div class="col-sm-6">','after' => '</div>','class'=>'form-control input-xs','error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))))); ?>
		<?php
		echo $this->Form->input('iddist',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('nom_cap',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('nombdist',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('nombprov',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('provincia_id',array('label'=>array('class'=>'control-label col-sm-2'),'empty' => 'Seleccionar'));
		echo $this->Form->input('nombdep',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('dcto',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('ley',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('fecha',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('area_minam',array('label'=>array('class'=>'control-label col-sm-2')));
	?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
					<?php echo $this->Form->button('Guardar', array('type' => 'submit','class'=>'btn btn-success'));  ?>
		</div>
	</div>
		<?php echo $this->Form->end(); ?>
</fieldset>