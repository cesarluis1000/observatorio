<h2><?php echo __('Presos'); ?></h2>

<!-- Buscador -->
<div class="row">
	<div class="col-md-10">
			<?php echo $this->Form->create('Preso', array('type' => 'get','url' => 'index','class' => 'form-inline','inputDefaults'=>array('div' => array('class' => 'form-group'),'class'=>'form-control input-xs'))); ?>
			<?php echo $this->Form->input($campo,array('required' => false,'label'=>false)); ?>
			<?php echo $this->Form->button('Buscar', array('type' => 'submit','class'=>'btn btn-primary btn-xs'));  ?>
			<?php echo $this->Form->button('Limpiar', array('type' => 'reset','class'=>'btn btn-primary btn-xs'));  ?>
			<?php echo $this->Form->end(); ?>
     </div>
     <div class="col-md-2 text-right">
    		<?php echo $this->Html->link($this->Html->tag('span','', array('class' => 'glyphicon glyphicon-file')).__(' Nuevo'),array('action' => 'add'),array('class' => 'btn btn-success btn-xs','escape'=>false)); ?>
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
			<th><?php echo $this->Paginator->sort('app_paterno'); ?></th>
			<th><?php echo $this->Paginator->sort('app_materno'); ?></th>
			<th><?php echo $this->Paginator->sort('nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('tipo_documento'); ?></th>
			<th><?php echo $this->Paginator->sort('nro_identidad'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_nac'); ?></th>
			<th><?php echo $this->Paginator->sort('edad'); ?></th>
			<th><?php echo $this->Paginator->sort('sexo'); ?></th>
			<th><?php echo $this->Paginator->sort('nacion'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_ingreso'); ?></th>
			<th><?php echo $this->Paginator->sort('nro_ingresos'); ?></th>
			<th><?php echo $this->Paginator->sort('delito_especifico_id'); ?></th>
			<th><?php echo $this->Paginator->sort('sit_juridi'); ?></th>
			<th><?php echo $this->Paginator->sort('impuesta_años'); ?></th>
			<th><?php echo $this->Paginator->sort('impuesta_meses'); ?></th>
			<th><?php echo $this->Paginator->sort('mot_ingreso'); ?></th>
			<th><?php echo $this->Paginator->sort('origen_peniten'); ?></th>
			<th><?php echo $this->Paginator->sort('estab_penitenciario_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($presos as $preso): ?>
	<tr>
		<td><?php echo h($preso['Preso']['id']); ?>&nbsp;</td>
		<td><?php echo h($preso['Preso']['app']); ?>&nbsp;</td>
		<td><?php echo h($preso['Preso']['apm']); ?>&nbsp;</td>
		<td><?php echo h($preso['Preso']['nombre']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($preso['TipoDocumento']['nombre'], array('controller' => 'tipo_documentos', 'action' => 'view', $preso['TipoDocumento']['id'])); ?>
		</td>
		<td><?php echo h($preso['Preso']['doc_ident']); ?>&nbsp;</td>
		<td><?php echo h($preso['Preso']['fecha_nac']); ?>&nbsp;</td>
		<td><?php echo h($preso['Preso']['edad']); ?>&nbsp;</td>
		<td><?php echo h($preso['Preso']['sexo']); ?>&nbsp;</td>
		<td><?php echo h($preso['Preso']['nacionalidad']); ?>&nbsp;</td>
		<td><?php echo h($preso['Preso']['fecha_ingreso']); ?>&nbsp;</td>
		<td><?php echo h($preso['Preso']['nro_ingresos']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($preso['DelitoEspecifico']['nombre'], array('controller' => 'delito_especificos', 'action' => 'view', $preso['DelitoEspecifico']['id'])); ?>
		</td>
		<td><?php echo h($preso['Preso']['sit_juridi']); ?>&nbsp;</td>
		<td><?php echo h($preso['Preso']['pena_impuesta_an']); ?>&nbsp;</td>
		<td><?php echo h($preso['Preso']['pena_impuesta_meses']); ?>&nbsp;</td>
		<td><?php echo h($preso['Preso']['mot_ingreso']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($preso['OrigenPenitenciario']['nombre'], array('controller' => 'origen_penitenciarios', 'action' => 'view', $preso['OrigenPenitenciario']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($preso['EstabPenitenciario']['nombre'], array('controller' => 'estab_penitenciarios', 'action' => 'view', $preso['EstabPenitenciario']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-eye-open')), array('action' => 'view', $preso['Preso']['id']),array('class' => 'btn btn-info btn-xs','escape'=>false)); ?>
			<?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-edit')), array('action' => 'edit', $preso['Preso']['id']),array('class' => 'btn btn-warning btn-xs','escape'=>false)); ?>
			<?php echo $this->Form->postLink($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')), array('action' => 'delete', $preso['Preso']['id']),array('class' => 'btn btn-danger btn-xs','escape'=>false), __('Are you sure you want to delete # %s?', $preso['Preso']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
</div>
