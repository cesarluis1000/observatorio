<h2><?php echo __('Denuncia'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nro Denuncia'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['nro_denuncia']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Categoria'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['categoria']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Distrito'); ?></dt>
		<dd>
			<?php echo $this->Html->link($denuncia['Distrito']['nombdist'], array('controller' => 'distritos', 'action' => 'view', $denuncia['Distrito']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Horizontal'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['horizontal']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vertical'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['vertical']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ubicacion'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['ubicacion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ubicacion2'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['ubicacion2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Hecho'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['fecha_hecho']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Registro'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['fecha_registro']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comiseria'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['comiseria']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['estado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creador'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['creador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creado'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['creado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificador'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['modificador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificado'); ?></dt>
		<dd>
			<?php echo h($denuncia['Denuncia']['modificado']); ?>
			&nbsp;
		</dd>
	</dl>
