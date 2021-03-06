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
	<meta name="description" content="La unidad del Observatorio del delito y la criminalidad tiene como misión el registro, procesamiento, análisis e interpretación de información relacionada a las faltas y delitos, crimen organizado, conflictos sociales y aspectos socio policiales, de carácter descriptivo e interpretativo con un enfoque criminológico" />
	<meta name="keywords" content="Observatorio, Observatorio del delito, análisis e interpretación, datos criminológicos, institución policial" />
	
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('bootstrap.min.css');
		echo $this->Html->css('bootstrap-datetimepicker.css');		
		echo $this->Html->css('ol.css');
		echo $this->Html->script('ol.js');		         
	?>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->	
	<?php echo $this->Html->script('jquery-3.2.1.min.js'); ?>	
	<?php echo $this->Html->script('Chart.min.js'); ?>
	<?php echo $this->Html->script('utils.js'); ?>
	<?php echo $this->Html->css('elmundotec.css'); ?>
	<base href="<?php echo Router::url('/', true);?>">	
	<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
</head>
<body>
	<div id="container">
	
		<div id="header" class="page-header">		
			<h1 id="titulo" class="banner">
			<?php    	
        	echo $this->Html->link(
        	    $this->Html->image('ODC_LOGO-v7.2_web2.png', ['alt' => 'observatorio']),
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
