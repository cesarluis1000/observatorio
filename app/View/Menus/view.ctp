<h2><?php echo __('Menu'); ?></h2>
	<dl class="dl-horizontal">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($menu['Menu']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($menu['Menu']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Menu'); ?></dt>
		<dd>
			<?php echo $this->Html->link($menu['ParentMenu']['nombre'], array('controller' => 'menus', 'action' => 'view', $menu['ParentMenu']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lft'); ?></dt>
		<dd>
			<?php echo h($menu['Menu']['lft']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rght'); ?></dt>
		<dd>
			<?php echo h($menu['Menu']['rght']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($menu['Group']['name'], array('controller' => 'groups', 'action' => 'view', $menu['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Aco'); ?></dt>
		<dd>
			<?php echo $this->Html->link($menu['Aco']['id'], array('controller' => 'acos', 'action' => 'view', $menu['Aco']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creador'); ?></dt>
		<dd>
			<?php echo h($menu['Menu']['creador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Creado'); ?></dt>
		<dd>
			<?php echo h($menu['Menu']['creado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificador'); ?></dt>
		<dd>
			<?php echo h($menu['Menu']['modificador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificado'); ?></dt>
		<dd>
			<?php echo h($menu['Menu']['modificado']); ?>
			&nbsp;
		</dd>
	</dl>
