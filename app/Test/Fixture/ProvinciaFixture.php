<?php
/**
 * Provincia Fixture
 */
class ProvinciaFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'first_idpr' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'nombprov' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'first_nomb' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'departamento_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'last_dcto' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'last_ley' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'first_fech' => array('type' => 'date', 'null' => false, 'default' => null),
		'last_fecha' => array('type' => 'date', 'null' => false, 'default' => null),
		'min_shape' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ha' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '15,3', 'unsigned' => false),
		'count' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
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
			'first_idpr' => 'Lorem ipsum dolor sit amet',
			'nombprov' => 'Lorem ipsum dolor sit amet',
			'first_nomb' => 'Lorem ipsum dolor sit amet',
			'departamento_id' => 1,
			'last_dcto' => 'Lorem ipsum dolor sit amet',
			'last_ley' => 'Lorem ipsum dolor sit amet',
			'first_fech' => '2019-01-02',
			'last_fecha' => '2019-01-02',
			'min_shape' => 'Lorem ipsum dolor sit amet',
			'ha' => '',
			'count' => 1,
			'creador' => 'Lorem ipsum dolor sit amet',
			'creado' => '2019-01-02 16:32:38',
			'modificador' => 'Lorem ipsum dolor sit amet',
			'modificado' => '2019-01-02 16:32:38'
		),
	);

}
