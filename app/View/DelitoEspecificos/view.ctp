<h2><?php echo __('Delito Especifico'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($delitoEspecifico['DelitoEspecifico']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($delitoEspecifico['DelitoEspecifico']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creador'); ?></dt>
		<dd>
			<?php echo h($delitoEspecifico['DelitoEspecifico']['creador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creado'); ?></dt>
		<dd>
			<?php echo h($delitoEspecifico['DelitoEspecifico']['creado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificador'); ?></dt>
		<dd>
			<?php echo h($delitoEspecifico['DelitoEspecifico']['modificador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificado'); ?></dt>
		<dd>
			<?php echo h($delitoEspecifico['DelitoEspecifico']['modificado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delito Generico'); ?></dt>
		<dd>
			<?php echo $this->Html->link($delitoEspecifico['DelitoGenerico']['nombre'], array('controller' => 'delito_genericos', 'action' => 'view', $delitoEspecifico['DelitoGenerico']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
