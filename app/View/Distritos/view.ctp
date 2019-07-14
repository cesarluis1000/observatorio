<h2><?php echo __('Distrito'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($distrito['Distrito']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Iddist'); ?></dt>
		<dd>
			<?php echo h($distrito['Distrito']['iddist']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nom Cap'); ?></dt>
		<dd>
			<?php echo h($distrito['Distrito']['nom_cap']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombdist'); ?></dt>
		<dd>
			<?php echo h($distrito['Distrito']['nombdist']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombprov'); ?></dt>
		<dd>
			<?php echo h($distrito['Distrito']['nombprov']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Provincia'); ?></dt>
		<dd>
			<?php echo $this->Html->link($distrito['Provincia']['nombprov'], array('controller' => 'provincias', 'action' => 'view', $distrito['Provincia']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombdep'); ?></dt>
		<dd>
			<?php echo h($distrito['Distrito']['nombdep']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dcto'); ?></dt>
		<dd>
			<?php echo h($distrito['Distrito']['dcto']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ley'); ?></dt>
		<dd>
			<?php echo h($distrito['Distrito']['ley']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha'); ?></dt>
		<dd>
			<?php echo h($distrito['Distrito']['fecha']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Area Minam'); ?></dt>
		<dd>
			<?php echo h($distrito['Distrito']['area_minam']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creador'); ?></dt>
		<dd>
			<?php echo h($distrito['Distrito']['creador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creado'); ?></dt>
		<dd>
			<?php echo h($distrito['Distrito']['creado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificador'); ?></dt>
		<dd>
			<?php echo h($distrito['Distrito']['modificador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificado'); ?></dt>
		<dd>
			<?php echo h($distrito['Distrito']['modificado']); ?>
			&nbsp;
		</dd>
	</dl>
