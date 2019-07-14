<div class="parametros form">
<?php echo $this->Form->create('Parametro'); ?>
	<fieldset>
		<legend><?php echo __('Edit Parametro'); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Parametro.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Parametro.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Parametros'), array('action' => 'index')); ?></li>
	</ul>
</div>
