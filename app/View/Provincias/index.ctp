<h2><?php echo __('Provincias'); ?></h2>

<!-- Buscador -->
<div class="row">
	<div class="col-md-10">
			<?php echo $this->Form->create('Provincia', array('type' => 'get','url' => 'index','class' => 'form-inline','inputDefaults'=>array('div' => array('class' => 'form-group'),'class'=>'form-control input-xs'))); ?>	
			<?php echo $this->Form->input($campo,array('required' => false,'label'=>false)); ?>
			<?php echo $this->Form->button('Buscar', array('type' => 'submit','class'=>'btn btn-primary btn-xs'));  ?>
			<?php echo $this->Form->button('Limpiar', array('type' => 'reset','class'=>'btn btn-primary btn-xs'));  ?>		
			<?php echo $this->Form->end(); ?>	
     </div>
     <div class="col-md-2 text-right">
    		<?php echo $this->Html->link($this->Html->tag('span','', array('class' => 'glyphicon glyphicon-file')).__(' Nuevo'),array('action' => 'add'),array('class' => 'btn btn-success btn-xs','escape'=>false)); ?>
    		<?php echo $this->Html->link($this->Html->tag('span','', array('class' => 'glyphicon glyphicon-file')).__(' Nuevo Json'),array('action' => 'addjson'),array('class' => 'btn btn-success btn-xs','escape'=>false)); ?>
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
			<th><?php echo $this->Paginator->sort('departamento_id'); ?></th>
			<th><?php echo $this->Paginator->sort('first_idpr'); ?></th>
			<th><?php echo $this->Paginator->sort('nombprov'); ?></th>
			<th><?php echo $this->Paginator->sort('last_dcto'); ?></th>
			<th><?php echo $this->Paginator->sort('last_ley'); ?></th>
			<th><?php echo $this->Paginator->sort('first_fech'); ?></th>
			<th><?php echo $this->Paginator->sort('last_fecha'); ?></th>
			<th><?php echo $this->Paginator->sort('min_shape'); ?></th>
			<th><?php echo $this->Paginator->sort('ha'); ?></th>
			<th><?php echo $this->Paginator->sort('count'); ?></th>			
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($provincias as $provincia): ?>
	<tr>
		<td><?php echo h($provincia['Provincia']['id']); ?>&nbsp;</td>		
		<td>
			<?php echo $this->Html->link($provincia['Departamento']['nombdep'], array('controller' => 'departamentos', 'action' => 'view', $provincia['Departamento']['id'])); ?>
		</td>
		<td><?php echo h($provincia['Provincia']['first_idpr']); ?>&nbsp;</td>
		<td><?php echo h($provincia['Provincia']['nombprov']); ?>&nbsp;</td>
		<td><?php echo h($provincia['Provincia']['last_dcto']); ?>&nbsp;</td>
		<td><?php echo h($provincia['Provincia']['last_ley']); ?>&nbsp;</td>
		<td><?php echo h($provincia['Provincia']['first_fech']); ?>&nbsp;</td>
		<td><?php echo h($provincia['Provincia']['last_fecha']); ?>&nbsp;</td>
		<td><?php echo h($provincia['Provincia']['min_shape']); ?>&nbsp;</td>
		<td><?php echo h($provincia['Provincia']['ha']); ?>&nbsp;</td>
		<td><?php echo h($provincia['Provincia']['count']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-eye-open')), array('action' => 'view', $provincia['Provincia']['id']),array('class' => 'btn btn-info btn-xs','escape'=>false)); ?>
			<?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-edit')), array('action' => 'edit', $provincia['Provincia']['id']),array('class' => 'btn btn-warning btn-xs','escape'=>false)); ?>
			<?php echo $this->Form->postLink($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')), array('action' => 'delete', $provincia['Provincia']['id']),array('class' => 'btn btn-danger btn-xs','escape'=>false), __('Are you sure you want to delete # %s?', $provincia['Provincia']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>	
</div>