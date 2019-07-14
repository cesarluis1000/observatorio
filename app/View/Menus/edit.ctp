<fieldset>
	<legend><?php echo __('Editar Menu'); ?></legend>
<?php echo $this->Form->create('Menu', array('class' => 'form-horizontal',
	'inputDefaults'=>array(
			'div' => array('class' => 'form-group'), 
			'between' => '<div class="col-sm-6">',  
			'after' => '</div>',
			'class'=>'form-control input-xs',
			'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))
		)
	)); ?>	
<div class="form-group">
<label for="PermisosAlias" class="col-sm-2 text-right">Parent</label>
<label for="PermisosAlias" class="col-sm-6 text-left"><?php echo $alias; ?></label>
</div>		
<?php
    echo $this->Form->input('id',array('type'=>'hidden','value'=>$menu_id));
    echo $this->Form->input('aro_id',array('type'=>'hidden','value'=>$aro_id));
	echo $this->Form->input('parent_id',array('type'=>'hidden','value'=>$parend_id));
	echo $this->Form->input('nombre',array('label'=>array('class'=>'control-label col-sm-2'),'required'=>'required','value'=>$nombre));
	echo $this->Form->input('aco_id',array('label'=>array('class'=>'control-label col-sm-2'),'options'=> $a_aplicaciones,'selected' => $aco_id));
?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
		<?php echo $this->Form->button('Guardar', array('type' => 'submit','class'=>'btn btn-success'));  ?>
	</div>
</div>
<?php echo $this->Form->end(); ?>