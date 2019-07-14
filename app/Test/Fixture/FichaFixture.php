<?php
/**
 * Ficha Fixture
 */
class FichaFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'nif' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'sede' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'app' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'apm' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'nombres' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'edad_real' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'edad_aparente' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'iris' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'boca' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'talla' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '4,2', 'unsigned' => false),
		'nariz' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'labios' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'peso' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '5,3', 'unsigned' => false),
		'oreja' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'sexo' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'complexion' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'fecha_nacimiento' => array('type' => 'date', 'null' => false, 'default' => null),
		'caracteristicas' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'senias_particulares' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'senias_particulares2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'senias_particulares3' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'lugar_resenia' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'foto_frente' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'perfil_derecho' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'formula_dactiloscopica' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'creador' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'creado' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modificador' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_spanish_ci', 'charset' => 'latin1'),
		'modificado' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'nif' => 'Lorem ipsum dolor sit amet',
			'sede' => 'Lorem ipsum dolor sit amet',
			'app' => 'Lorem ipsum dolor sit amet',
			'apm' => 'Lorem ipsum dolor sit amet',
			'nombres' => 'Lorem ipsum dolor sit amet',
			'edad_real' => 1,
			'edad_aparente' => 1,
			'iris' => 'Lorem ipsum dolor sit amet',
			'boca' => 'Lorem ipsum dolor sit amet',
			'talla' => '',
			'nariz' => 'Lorem ipsum dolor sit amet',
			'labios' => 'Lorem ipsum dolor sit amet',
			'peso' => '',
			'oreja' => 'Lorem ipsum dolor sit amet',
			'sexo' => 'Lorem ipsum dolor sit amet',
			'complexion' => 'Lorem ipsum dolor sit amet',
			'fecha_nacimiento' => '2019-01-09',
			'caracteristicas' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'senias_particulares' => 'Lorem ipsum dolor sit amet',
			'senias_particulares2' => 'Lorem ipsum dolor sit amet',
			'senias_particulares3' => 'Lorem ipsum dolor sit amet',
			'lugar_resenia' => 'Lorem ipsum dolor sit amet',
			'foto_frente' => 'Lorem ipsum dolor sit amet',
			'perfil_derecho' => 'Lorem ipsum dolor sit amet',
			'formula_dactiloscopica' => 'Lorem ipsum dolor sit amet',
			'creador' => 'Lorem ipsum dolor sit amet',
			'creado' => '2019-01-09 17:45:29',
			'modificador' => 'Lorem ipsum dolor sit amet',
			'modificado' => '2019-01-09 17:45:29'
		),
	);

}
