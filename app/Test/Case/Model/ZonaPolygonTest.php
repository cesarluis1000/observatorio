<?php
App::uses('ZonaPolygon', 'Model');

/**
 * ZonaPolygon Test Case
 */
class ZonaPolygonTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.zona_polygon',
		'app.institucion',
		'app.distrito',
		'app.provincia',
		'app.departamento',
		'app.dep_polygon',
		'app.prov_polygon',
		'app.dist_polygon',
		'app.denuncia',
		'app.tipo_institucion'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ZonaPolygon = ClassRegistry::init('ZonaPolygon');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ZonaPolygon);

		parent::tearDown();
	}

}
