<?php
/**
 * Denuncia Fixture
 */
class DenunciaFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'nro_denuncia' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'categoria' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'distrito_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'horizontal' => array('type' => 'decimal', 'null' => true, 'default' => null, 'length' => '18,15', 'unsigned' => false),
		'vertical' => array('type' => 'decimal', 'null' => true, 'default' => null, 'length' => '18,15', 'unsigned' => false),
		'ubicacion' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'ubicacion2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'fecha_hecho' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'fecha_registro' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'comiseria' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'estado' => array('type' => 'string', 'null' => true, 'default' => 'A', 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'creador' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'creado' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modificador' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'modificado' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_denuncias_distritos1' => array('column' => 'distrito_id', 'unique' => 0)
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
			'nro_denuncia' => 'Lorem ipsum dolor sit amet',
			'categoria' => 'Lorem ipsum dolor sit amet',
			'distrito_id' => 1,
			'horizontal' => '',
			'vertical' => '',
			'ubicacion' => 'Lorem ipsum dolor sit amet',
			'ubicacion2' => 'Lorem ipsum dolor sit amet',
			'fecha_hecho' => 'Lorem ipsum dolor sit amet',
			'fecha_registro' => 'Lorem ipsum dolor sit amet',
			'comiseria' => 'Lorem ipsum dolor sit amet',
			'estado' => 'Lorem ipsum dolor sit amet',
			'creador' => 'Lorem ipsum dolor sit amet',
			'creado' => '2019-02-07 04:47:03',
			'modificador' => 'Lorem ipsum dolor sit amet',
			'modificado' => '2019-02-07 04:47:03'
		),
	);

}
