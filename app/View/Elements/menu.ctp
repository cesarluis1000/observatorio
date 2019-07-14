<div class="row">
	<div class="col-md-12">
		<div class="panel panel-group" id="main">
			<div class="panel-body">
				<div class="panel-heading">  
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#main" href="#accordion">
							<span class="glyphicon glyphicon-folder-close text-primary"></span> Menu
						</a>
					</h4>  
				</div>
				
				<div class="panel-collapse panel-scroll collapse in" id="accordion">
				
					
					<?php foreach ($a_menu as $menu):?>
						<div class="panel panel-default">					
    						<div class="panel-heading">
    							<h4 class="panel-title">
    								<a data-toggle="collapse" data-parent="#accordion" href="<?php echo '#collapse'.$menu['Menu']['id']; ?>">
    									<span class="glyphicon glyphicon-folder-close text-primary"></span>&nbsp;<?php echo $menu['Menu']['nombre']; ?>
    								</a>
    							</h4>
    						</div>
							<?php if(!empty($menu['Acciones'])):?>
    						<div id="<?php echo 'collapse'.$menu['Menu']['id']; ?>" class="panel-collapse collapse in">
    							<div class="panel-body">
    								<table class="table table-condensed">
    									<tbody>
    										<?php foreach ($menu['Acciones'] as $accion):?>
    										<tr>
    											<td>                                        
    												<?php  echo $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-list text-primary')).'&nbsp;'.$accion['Menu']['nombre'],
    												            array('controller' => $accion['Controlador']['alias'],'action' => $accion['Aco']['alias']),array('escape'=>false,'class'=>'menu-level2') ); ?>
    											</td>
    										</tr>
    										<?php endforeach;?>
    									</tbody>
    								</table>
    							</div>
    						</div>
							<?php endif; ?>
						</div>
					<?php endforeach;?>
												

				</div>
			</div>
		</div>
	</div>
</div>

<div id="push"></div>
        