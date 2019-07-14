<?php if(!empty($currentUser)): ?>
	<h6 class="text-right">Bienvenido(a): <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
		<?php echo $currentUser['username'].' - '.$currentUser['Group']['name']; ?>
		<?php  echo $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-off text-danger')).'&nbsp;'.__('Logout'),array('controller' => 'Users','action' => 'logout'),array('escape'=>false,'class'=>'menu-level2') ); ?>
	</h6>
<?php else: ?>
	<h6 class="text-right">Iniciar Sesión <span class="glyphicon glyphicon-user" aria-hidden="true"></span>		
		<?php  echo $this->Html->link($this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-off text-danger')).'&nbsp;'.__('Login'),array('controller' => 'Users','action' => 'login'),array('escape'=>false,'class'=>'menu-level2') ); ?>
	</h6>
<?php endif ?>