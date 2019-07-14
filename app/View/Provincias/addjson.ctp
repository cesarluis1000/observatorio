<fieldset>
	<legend><?php echo __('Nuevas Provincias'); ?></legend>
	<?php echo $this->Form->create('Provincia', array('class' => 'form-horizontal',
		'inputDefaults'=>array('div' => array('class' => 'form-group'),'between' => '<div class="col-sm-6">','after' => '</div>','class'=>'form-control input-xs','error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))))); ?>
		<?php echo $this->Form->textarea('datajson',array('rows' => '20', 'class'=>'control-label col-sm-11 text-left'));?>
	<div class="form-group">
		<div class="col-sm-offset-9 col-sm-10"><br>
					<?php echo $this->Form->button('Guardar', array('type' => 'submit','class'=>'btn btn-success'));  ?>
		</div>
	</div>
		<?php echo $this->Form->end(); ?>
</fieldset>