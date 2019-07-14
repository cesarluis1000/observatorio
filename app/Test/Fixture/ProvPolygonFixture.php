<?php
/**
 * ProvPolygon Fixture
 */
class ProvPolygonFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'provincia_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'horizontal' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '18,14', 'unsigned' => false),
		'vertical' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '18,15', 'unsigned' => false),
		'creador' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'creado' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modificador' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'modificado' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'provincia_id' => 1,
			'horizontal' => '',
			'vertical' => '',
			'creador' => 'Lorem ipsum dolor sit amet',
			'creado' => '2019-01-02 20:00:22',
			'modificador' => 'Lorem ipsum dolor sit amet',
			'modificado' => '2019-01-02 20:00:22'
		),
	);

}
