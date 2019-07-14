<h2><?php echo __('Provincia'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Idpr'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['first_idpr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombprov'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['nombprov']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Nomb'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['first_nomb']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Departamento'); ?></dt>
		<dd>
			<?php echo $this->Html->link($provincia['Departamento']['nombdep'], array('controller' => 'departamentos', 'action' => 'view', $provincia['Departamento']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Dcto'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['last_dcto']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Ley'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['last_ley']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Fech'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['first_fech']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Fecha'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['last_fecha']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Min Shape'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['min_shape']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ha'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['ha']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Count'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['count']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creador'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['creador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creado'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['creado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificador'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['modificador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificado'); ?></dt>
		<dd>
			<?php echo h($provincia['Provincia']['modificado']); ?>
			&nbsp;
		</dd>
	</dl>
