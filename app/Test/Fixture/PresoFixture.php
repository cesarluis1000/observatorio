<?php
/**
 * Preso Fixture
 */
class PresoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'app' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'apm' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'doc_ident' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'fecha_ingreso' => array('type' => 'date', 'null' => false, 'default' => null),
		'nro_ingresos' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'sit_juridi' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'pena_impuesta_an' => array('type' => 'string', 'null' => false, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'mot_ingreso' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'fecha_nac' => array('type' => 'date', 'null' => false, 'default' => null),
		'edad' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'sexo' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'nacionalidad' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'nomb_padre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'app_padre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'apm_padre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'nomb_madre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'app_madre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'apm_madre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'creador' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'creado' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modificador' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'modificado' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'tipo_documento_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'estab_penitenciario_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'delito_especifico_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'origen_penitenciario_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'pena_impuesta_meses' => array('type' => 'string', 'null' => false, 'length' => 45, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_presos_tipo_documentos1_idx' => array('column' => 'tipo_documento_id', 'unique' => 0),
			'fk_presos_estab_penitenciarios1_idx' => array('column' => 'estab_penitenciario_id', 'unique' => 0),
			'fk_presos_delito_especificos1_idx' => array('column' => 'delito_especifico_id', 'unique' => 0),
			'fk_presos_origen_penitenciarios1_idx' => array('column' => 'origen_penitenciario_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'nombre' => 'Lorem ipsum dolor sit amet',
			'app' => 'Lorem ipsum dolor sit amet',
			'apm' => 'Lorem ipsum dolor sit amet',
			'doc_ident' => 'Lorem ip',
			'fecha_ingreso' => '2022-05-04',
			'nro_ingresos' => 'Lorem ipsum dolor sit amet',
			'sit_juridi' => 'Lorem ipsum dolor sit amet',
			'pena_impuesta_an' => 'Lorem ipsum dolor sit amet',
			'mot_ingreso' => 'Lorem ipsum dolor sit amet',
			'fecha_nac' => '2022-05-04',
			'edad' => 1,
			'sexo' => 'Lorem ipsum dolor sit amet',
			'nacionalidad' => 'Lorem ipsum dolor sit amet',
			'nomb_padre' => 'Lorem ipsum dolor sit amet',
			'app_padre' => 'Lorem ipsum dolor sit amet',
			'apm_padre' => 'Lorem ipsum dolor sit amet',
			'nomb_madre' => 'Lorem ipsum dolor sit amet',
			'app_madre' => 'Lorem ipsum dolor sit amet',
			'apm_madre' => 'Lorem ipsum dolor sit amet',
			'creador' => 'Lorem ipsum dolor sit amet',
			'creado' => '2022-05-04 09:27:36',
			'modificador' => 'Lorem ipsum dolor sit amet',
			'modificado' => '2022-05-04 09:27:36',
			'tipo_documento_id' => 1,
			'estab_penitenciario_id' => 1,
			'delito_especifico_id' => 1,
			'origen_penitenciario_id' => 1,
			'pena_impuesta_meses' => 'Lorem ipsum dolor sit amet'
		),
	);

}
