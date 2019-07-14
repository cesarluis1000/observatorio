<div class="parametros form">
<?php echo $this->Form->create('Parametro'); ?>
	<fieldset>
		<legend><?php echo __('Add Parametro'); ?></legend>
	<?php
		echo $this->Form->input('modulo');
		echo $this->Form->input('variable');
		echo $this->Form->input('valor');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Parametros'), array('action' => 'index')); ?></li>
	</ul>
</div>
