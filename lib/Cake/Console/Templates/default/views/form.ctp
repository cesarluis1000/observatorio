<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<fieldset>
	<legend><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></legend>
	<?php echo "<?php echo \$this->Form->create('{$modelClass}', array('class' => 'form-horizontal',
		'inputDefaults'=>array('div' => array('class' => 'form-group'),'between' => '<div class=\"col-sm-6\">','after' => '</div>','class'=>'form-control input-xs','error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))))); ?>\n"; ?>
	<?php
			echo "\t<?php\n";
			foreach ($fields as $field) {
				if (strpos($action, 'add') !== false && $field === $primaryKey) {
					continue;
				} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
					echo "\t\techo \$this->Form->input('{$field}',array('label'=>array('class'=>'control-label col-sm-2')));\n";
				}
			}
			if (!empty($associations['hasAndBelongsToMany'])) {
				foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
					echo "\t\techo \$this->Form->input('{$assocName}',array('label'=>array('class'=>'control-label col-sm-2')));\n";
				}
			}
			echo "\t?>\n";
	?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo "\t\t<?php echo \$this->Form->button('Guardar', array('type' => 'submit','class'=>'btn btn-success'));  ?>\n";?>
		</div>
	</div>
	<?php echo "\t<?php echo \$this->Form->end(); ?>\n";?>
</fieldset>