<fieldset>
	<legend><?php echo __('Editar Aplicación'); ?></legend>
<?php echo $this->Form->create('Permisos', array('class' => 'form-horizontal',
	'inputDefaults'=>array(
			'div' => array('class' => 'form-group'), 
			'between' => '<div class="col-sm-6">',  
			'after' => '</div>',
			'class'=>'form-control input-xs',
			'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))
		)
	)); ?>	
<div class="form-group">
<label for="PermisosAlias" class="col-sm-2 text-right">Id</label>
<label for="PermisosAlias" class="col-sm-6 text-left"><?php echo $alias; ?></label>
</div>		
<?php
	echo $this->Form->input('id',array('type'=>'hidden','value'=>$aco['Aco']['id']));
	echo $this->Form->input('alias',array('label'=>array('class'=>'control-label col-sm-2'),'required'=>'required','value'=>$aco['Aco']['alias']));
?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		<?php echo $this->Form->button('Guardar', array('type' => 'submit','class'=>'btn btn-success'));  ?>
	</div>
</div>
<?php echo $this->Form->end(); ?>