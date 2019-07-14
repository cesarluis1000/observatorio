<h2><?php echo __('Fichas de Identificación'); ?></h2>

<!-- Buscador -->
<div class="row">
	<div class="col-md-10">
			<?php echo $this->Form->create('Ficha', array('type' => 'get','url' => 'index','class' => 'form-inline','inputDefaults'=>array('div' => array('class' => 'form-group'),'class'=>'form-control input-xs'))); ?>	
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
			<th><?php echo $this->Paginator->sort('nif'); ?></th>
			<th><?php echo $this->Paginator->sort('sede'); ?></th>
			<th><?php echo $this->Paginator->sort('app'); ?></th>
			<th><?php echo $this->Paginator->sort('apm'); ?></th>
			<th><?php echo $this->Paginator->sort('nombres'); ?></th>
			<th><?php echo $this->Paginator->sort('edad_real'); ?></th>
			<th><?php echo $this->Paginator->sort('edad_aparente'); ?></th>
			<th><?php echo $this->Paginator->sort('iris'); ?></th>
			<th><?php echo $this->Paginator->sort('boca'); ?></th>
			<th><?php echo $this->Paginator->sort('talla'); ?></th>
			<th><?php echo $this->Paginator->sort('nariz'); ?></th>
			<th><?php echo $this->Paginator->sort('labios'); ?></th>
			<th><?php echo $this->Paginator->sort('peso'); ?></th>
			<th><?php echo $this->Paginator->sort('oreja'); ?></th>
			<th><?php echo $this->Paginator->sort('sexo'); ?></th>
			<th><?php echo $this->Paginator->sort('complexion'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_nacimiento'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($fichas as $ficha): ?>
	<tr>
		<td><?php echo h($ficha['Ficha']['id']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['nif']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['sede']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['app']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['apm']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['nombres']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['edad_real']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['edad_aparente']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['iris']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['boca']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['talla']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['nariz']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['labios']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['peso']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['oreja']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['sexo']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['complexion']); ?>&nbsp;</td>
		<td><?php echo h($ficha['Ficha']['fecha_nacimiento']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-eye-open')), array('action' => 'view', $ficha['Ficha']['id']),array('class' => 'btn btn-info btn-xs','escape'=>false)); ?>
			<?php echo $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-edit')), array('action' => 'edit', $ficha['Ficha']['id']),array('class' => 'btn btn-warning btn-xs','escape'=>false)); ?>
			<?php echo $this->Form->postLink($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')), array('action' => 'delete', $ficha['Ficha']['id']),array('class' => 'btn btn-danger btn-xs','escape'=>false), __('Are you sure you want to delete # %s?', $ficha['Ficha']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>	
</div>