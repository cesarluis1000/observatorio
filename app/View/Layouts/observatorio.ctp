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
	<div id="container" class="mapcontainer">
		
		
		<div id="content" class="row">			
			<!-- Vista -->
			<div class="index mapindex col-md-12">
				<?php echo $this->Flash->render(); ?>
				<?php echo $this->fetch('content'); ?>
			</div>
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
