<?php
/**
 * Institucion Fixture
 */
class InstitucionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'latitud' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'longitud' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'estado' => array('type' => 'string', 'null' => false, 'default' => 'A', 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'creador' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'creado' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modificador' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'modificado' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'tipo_institucion_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_instituciones_tipo_instituciones1_idx' => array('column' => 'tipo_institucion_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'latitud' => 'Lorem ipsum dolor sit amet',
			'longitud' => 'Lorem ipsum dolor sit amet',
			'estado' => 'Lorem ipsum dolor sit amet',
			'creador' => 'Lorem ipsum dolor sit amet',
			'creado' => '2019-03-21 16:35:35',
			'modificador' => 'Lorem ipsum dolor sit amet',
			'modificado' => '2019-03-21 16:35:35',
			'tipo_institucion_id' => 1
		),
	);

}
