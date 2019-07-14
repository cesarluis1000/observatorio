<!DOCTYPE html>
<html>
<head>	
	<meta charset="UTF-8">
	<!-- <?php echo $this->Html->charset(); ?> -->
	<html lang="es">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?php echo "Observatorio del Delito y de la Criminalidad"; ?>
	</title>	
	<meta name="description" content="Compra por Internet en elmundotec.com de forma segura y fácil, encontrarás miles de productos y OFERTAS increíbles. Envíos a todo el PERÚ." />
	<meta name="keywords" content="elmundotec, comprar online, elmundotec.com, comprar por internet, comprar en peru, comprar online en peru, comprar por internet en peru" />
	
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('bootstrap.min.css');
		echo $this->Html->css('bootstrap-datetimepicker.css');
		echo $this->Html->css('elmundotec.css');
		echo $this->Html->css('ol.css');
		echo $this->Html->script('ol.js');		         
	?>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<?php echo $this->Html->script('jquery-3.2.1.min.js'); ?>
	<base href="<?php echo Router::url('/', true);?>">	
	<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
</head>
<body>
	<div id="container">
	
		<div id="header" class="page-header">		
			<h1 id="titulo" class="banner">
			<?php    	
        	echo $this->Html->link(
        	    $this->Html->image('dircri_banner.png', ['alt' => 'observatorio']),
        	    '/?n='.time(),['escapeTitle' => false, 'title' =>'observatorio']
        	    );
        	?>
        	</h1>        	     	
			<?php echo $this->element('logeado'); ?>
		</div>
		
		<div id="content" class="row">
			<!-- logeado -->
			<?php if(!empty($currentUser)): ?>
				<!-- Menu -->
				<div class="col-md-2">
					<?php echo $this->element('menu'); ?>
				</div>
				<!-- Vista -->
				<div class="index col-md-10">
					<?php echo $this->Flash->render(); ?>
					<?php echo $this->fetch('content'); ?>
				</div>
			<?php else: ?>
				<!-- Vista -->
				<div class="index col-md-12">
					<?php echo $this->Flash->render(); ?>
					<?php echo $this->fetch('content'); ?>
				</div>
			<?php endif; ?>
		</div>
		
		
		
	</div>
	
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <?php echo $this->Html->script('bootstrap.min.js'); ?>
    <!-- Bootstrap datetimepicker Plugin -->
    <?php echo $this->Html->script('moment.min.js'); ?>
    <?php echo $this->Html->script('bootstrap-datetimepicker.min.js'); ?>
    <?php echo $this->Html->script('locale/es.js'); ?>
	<?php echo $this->Html->script('elmundotec.js'); ?>
</body>
</html>
