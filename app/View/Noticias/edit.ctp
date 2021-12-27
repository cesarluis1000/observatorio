<fieldset>
	<legend><?php echo __('Edit Noticia'); ?></legend>
	<?php echo $this->Form->create('Noticia', array('class' => 'form-horizontal','type' => 'file',
		'inputDefaults'=>array('div' => array('class' => 'form-group'),'between' => '<div class="col-sm-6">','after' => '</div>','class'=>'form-control input-xs','error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))))); ?>
		<?php
		echo $this->Form->input('id',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('titulo',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('descripcion',array('label'=>array('class'=>'control-label col-sm-2')));
		echo $this->Form->input('fecha',array('label'=>array('class'=>'control-label col-sm-2'),'type' => 'text','placeholder'=>'YYYY-MM-DD HH:mm:ss'));
		echo $this->Form->input('file', array('type' => 'file','label'=>array('text'=>'Imagen', 'class'=>'control-label col-sm-2')));
		?>
		
		<?php if (!empty($this->request->data['Noticia']['imagen'])) { ?>
	  	<div class="form-group">
    		<div class="col-sm-offset-2 col-sm-10">    		
    			<?php $imagen_src = $this->webroot.$webFolder.$imagen; ?>
				<img src="<?php echo $imagen_src;?>" width="300">    			
    		</div>
    	</div>
    	<?php } ?>

	<?php 
		echo $this->Form->input('enlace',array('label'=>array('class'=>'control-label col-sm-2'),'type' => 'text'));
		echo $this->Form->input('estado',array('label'=>array('class'=>'control-label col-sm-2'),'options'=> $a_estados,'empty' => 'Seleccionar'));
	?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
					<?php echo $this->Form->button('Guardar', array('type' => 'submit','class'=>'btn btn-success'));  ?>
		</div>
	</div>
		<?php echo $this->Form->end(); ?>
</fieldset>