<h2><?php echo __('Institucion'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($institucion['Institucion']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($institucion['Institucion']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ubicacion'); ?></dt>
		<dd>
			<?php echo h($institucion['Institucion']['ubicacion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Latitud'); ?></dt>
		<dd>
			<?php echo h($institucion['Institucion']['latitud']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Longitud'); ?></dt>
		<dd>
			<?php echo h($institucion['Institucion']['longitud']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($institucion['Institucion']['estado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Distrito'); ?></dt>
		<dd>
			<?php echo $this->Html->link($institucion['Distrito']['nombdist'], array('controller' => 'distritos', 'action' => 'view', $institucion['Distrito']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tipo Institucion'); ?></dt>
		<dd>
			<?php echo $this->Html->link($institucion['TipoInstitucion']['institucion'], array('controller' => 'tipo_instituciones', 'action' => 'view', $institucion['TipoInstitucion']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creador'); ?></dt>
		<dd>
			<?php echo h($institucion['Institucion']['creador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creado'); ?></dt>
		<dd>
			<?php echo h($institucion['Institucion']['creado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificador'); ?></dt>
		<dd>
			<?php echo h($institucion['Institucion']['modificador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificado'); ?></dt>
		<dd>
			<?php echo h($institucion['Institucion']['modificado']); ?>
			&nbsp;
		</dd>
	</dl>
