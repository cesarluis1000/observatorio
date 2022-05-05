<h2><?php echo __('Preso'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('App'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['app']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Apm'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['apm']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tipo Documento'); ?></dt>
		<dd>
			<?php echo $this->Html->link($preso['TipoDocumento']['nombre'], array('controller' => 'tipo_documentos', 'action' => 'view', $preso['TipoDocumento']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Doc Ident'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['doc_ident']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Ingreso'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['fecha_ingreso']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nro Ingresos'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['nro_ingresos']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sit Juridi'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['sit_juridi']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pena Impuesta An'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['pena_impuesta_an']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mot Ingreso'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['mot_ingreso']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Nac'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['fecha_nac']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Edad'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['edad']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sexo'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['sexo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nacionalidad'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['nacionalidad']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nomb Padre'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['nomb_padre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('App Padre'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['app_padre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Apm Padre'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['apm_padre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nomb Madre'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['nomb_madre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('App Madre'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['app_madre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Apm Madre'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['apm_madre']); ?>
			&nbsp;
		</dd>

		<dt><?php echo __('Estab Penitenciario'); ?></dt>
		<dd>
			<?php echo $this->Html->link($preso['EstabPenitenciario']['nombre'], array('controller' => 'estab_penitenciarios', 'action' => 'view', $preso['EstabPenitenciario']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Delito Especifico'); ?></dt>
		<dd>
			<?php echo $this->Html->link($preso['DelitoEspecifico']['delito_generico_id'], array('controller' => 'delito_especificos', 'action' => 'view', $preso['DelitoEspecifico']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Origen Penitenciario'); ?></dt>
		<dd>
			<?php echo $this->Html->link($preso['OrigenPenitenciario']['nombre'], array('controller' => 'origen_penitenciarios', 'action' => 'view', $preso['OrigenPenitenciario']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pena Impuesta Meses'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['pena_impuesta_meses']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creador'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['creador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creado'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['creado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificador'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['modificador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificado'); ?></dt>
		<dd>
			<?php echo h($preso['Preso']['modificado']); ?>
			&nbsp;
		</dd>
	</dl>
