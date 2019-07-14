<?php
/**
 * Distrito Fixture
 */
class DistritoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'iddist' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'nom_cap' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'nombdist' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'nombprov' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'provincia_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'nombdep' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'dcto' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ley' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'fecha' => array('type' => 'date', 'null' => true, 'default' => null),
		'area_minam' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '15,3', 'unsigned' => false),
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
			'iddist' => 'Lorem ipsum dolor sit amet',
			'nom_cap' => 'Lorem ipsum dolor sit amet',
			'nombdist' => 'Lorem ipsum dolor sit amet',
			'nombprov' => 'Lorem ipsum dolor sit amet',
			'provincia_id' => 1,
			'nombdep' => 'Lorem ipsum dolor sit amet',
			'dcto' => 'Lorem ipsum dolor sit amet',
			'ley' => 'Lorem ipsum dolor sit amet',
			'fecha' => '2019-01-03',
			'area_minam' => '',
			'creador' => 'Lorem ipsum dolor sit amet',
			'creado' => '2019-01-03 06:15:11',
			'modificador' => 'Lorem ipsum dolor sit amet',
			'modificado' => '2019-01-03 06:15:11'
		),
	);

}
