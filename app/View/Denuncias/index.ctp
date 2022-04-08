<h2><?php echo __('Denuncias'); ?></h2>

<!-- Buscador -->
<div class="row">
	<div class="col-md-10">
			<?php echo $this->Form->create('Denuncia', array('type' => 'get','url' => 'index','class' => 'form-inline','inputDefaults'=>array('div' => array('class' => 'form-group'),'class'=>'form-control input-xs'))); ?>
			<?php echo $this->Form->input($campo,array('required' => false,'label'=>false)); ?>
			<?php echo $this->Form->button('Buscar', array('type' => 'submit','class'=>'btn btn-primary btn-xs'));  ?>
			<?php echo $this->Form->button('Limpiar', array('type' => 'reset','class'=>'btn btn-primary btn-xs'));  ?>
			<?php echo $this->Form->end(); ?>
     </div>
     <div class="col-md-2 text-right">
    		<?php echo $this->Html->link($this->Html->tag('span','', array('class' => 'glyphicon glyphicon-file')).__(' Nuevo'),array('action' => 'add'),array('class' => 'btn btn-success btn-xs','escape'=>false)); ?>
			<?php echo $this->Html->link($this->Html->tag('span','', array('class' => 'glyphicon glyphicon-th-list')).__(' Nuevo'),
        		    array('controller' => 'Denuncias', 'action' => 'add_list',$denuncia['Denuncia']['id']),array('class' => 'btn btn-default btn-xs','escape'=>false)); ?>
    </div>
</div>

<!-- Paginador y boton Nuevo -->
<?php $this->Paginator->options['url']['?'] = $this->params['url']; ?>
<div class="row text-right">
    <div class="col-md-12">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm">
				<?php
					echo $this->Paginator->prev('< ' . __('prev'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
					echo $this->Paginator->numbers(array('separator' => '','tag' => 'li','currentTag' => 'a', 'currentClass' => 'active','first' => 1));
					echo $this->Paginator->next(__('next') . ' >', array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
				?>
            </ul>
        </nav>
    </div>
</div>

<!-- Contenido de los registros y las acciones -->
<div class="table-responsive">
<table class="table table-hover table-condensed">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('nro_denuncia'); ?></th>
			<th><?php echo $this->Paginator->sort('categoria'); ?></th>
			<th><?php echo $this->Paginator->sort('distrito_id'); ?></th>
			<th><?php echo $this->Paginator->sort('horizontal'); ?></th>
			<th><?php echo $this->Paginator->sort('vertical'); ?></th>
			<th><?php echo $this->Paginator->sort('ubicacion'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_hecho'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_registro'); ?></th>
			<th><?php echo $this->Paginator->sort('comiseria'); ?></th>
			<th><?php echo $this->Paginator->sort('estado'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($denuncias as $denuncia): ?>
	<tr>
		<td><?php echo h($denuncia['Denuncia']['id']); ?>&nbsp;</td>
		<td><?php echo h($denuncia['Denuncia']['nro_denuncia']); ?>&nbsp;</td>
		<td><?php echo h($denuncia['Denuncia']['categoria']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($denuncia['Distrito']['nombdist'], array('controller' => 'distritos', 'action' => 'view', $denuncia['Distrito']['id'])); ?>
		</td>
		<td><?php echo h($denuncia['Denuncia']['horizontal']); ?>&nbsp;</td>
		<td><?php echo h($denuncia['Denuncia']['vertical']); ?>&nbsp;</td>
		<td><?php echo h($denuncia['Denuncia']['ubicacion']); ?>&nbsp;</td>
		<td><?php echo h($denuncia['Denuncia']['fecha_hecho']); ?>&nbsp;</td>
		<td><?php echo h($denuncia['Denuncia']['fecha_registro']); ?>&nbsp;</td>
		<td><?php echo h($denuncia['Denuncia']['comiseria']); ?>&nbsp;</td>
		<td><?php echo h($denuncia['Denuncia']['estado']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-eye-open')), array('action' => 'view', $denuncia['Denuncia']['id']),array('class' => 'btn btn-info btn-xs','escape'=>false)); ?>
			<?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-edit')), array('action' => 'edit', $denuncia['Denuncia']['id']),array('class' => 'btn btn-warning btn-xs','escape'=>false)); ?>
			<?php echo $this->Form->postLink($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')), array('action' => 'delete', $denuncia['Denuncia']['id']),array('class' => 'btn btn-danger btn-xs','escape'=>false), __('Are you sure you want to delete # %s?', $denuncia['Denuncia']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
</div>
