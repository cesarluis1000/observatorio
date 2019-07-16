<h2><?php echo __('Zona Polygon'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($zonaPolygon['ZonaPolygon']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Institucion'); ?></dt>
		<dd>
			<?php echo $this->Html->link($zonaPolygon['Institucion']['nombre'], array('controller' => 'instituciones', 'action' => 'view', $zonaPolygon['Institucion']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Horizontal'); ?></dt>
		<dd>
			<?php echo h($zonaPolygon['ZonaPolygon']['horizontal']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vertical'); ?></dt>
		<dd>
			<?php echo h($zonaPolygon['ZonaPolygon']['vertical']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Orden'); ?></dt>
		<dd>
			<?php echo h($zonaPolygon['ZonaPolygon']['orden']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creador'); ?></dt>
		<dd>
			<?php echo h($zonaPolygon['ZonaPolygon']['creador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creado'); ?></dt>
		<dd>
			<?php echo h($zonaPolygon['ZonaPolygon']['creado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificador'); ?></dt>
		<dd>
			<?php echo h($zonaPolygon['ZonaPolygon']['modificador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificado'); ?></dt>
		<dd>
			<?php echo h($zonaPolygon['ZonaPolygon']['modificado']); ?>
			&nbsp;
		</dd>
	</dl>
