<?php
/**
 * ZonaPolygon Fixture
 */
class ZonaPolygonFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'institucion_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'horizontal' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '11,8', 'unsigned' => false),
		'vertical' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '10,8', 'unsigned' => false),
		'orden' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'creador' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'creado' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modificador' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'modificado' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_sede_polygons_instituciones1_idx' => array('column' => 'institucion_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_spanish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'institucion_id' => 1,
			'horizontal' => '',
			'vertical' => '',
			'orden' => 1,
			'creador' => 'Lorem ipsum dolor sit amet',
			'creado' => '2019-07-15 19:08:32',
			'modificador' => 'Lorem ipsum dolor sit amet',
			'modificado' => '2019-07-15 19:08:32'
		),
	);

}
