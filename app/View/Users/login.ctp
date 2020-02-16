<section class="outer-wrapper">
  <div class="inner-wrapper">
		<div class="col-sm-4 col-sm-offset-4">
			<fieldset>
				<legend><?php echo __('Login'); ?></legend>
				<?php echo $this->Form->create('User', array('class' => 'form-horizontal',
					'inputDefaults'=>array('div' => array('class' => 'form-group'),'between' => '<div>','after' => '</div>','class'=>'form-control input-xs','error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))))); ?>
					<?php
					echo $this->Form->input('username',array('label'=>array('class'=>'control-label'),'placeholder'=>'Username'));
					echo $this->Form->input('password',array('label'=>array('class'=>'control-label'),'placeholder'=>'Password'));
				?>
				<div class="form-group">
					<div class="text-left">
								<?php echo $this->Form->button('Login', array('type' => 'submit','class'=>'btn btn-success'));  ?>
					</div>
				</div>
					<?php echo $this->Form->end(); ?>
			</fieldset>
		</div>
	</div>
</section>