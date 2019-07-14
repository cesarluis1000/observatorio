<?php
App::uses('Denuncia', 'Model');

/**
 * Denuncia Test Case
 */
class DenunciaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.denuncia',
		'app.distrito',
		'app.provincia',
		'app.departamento',
		'app.dep_polygon',
		'app.prov_polygon',
		'app.dist_polygon'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Denuncia = ClassRegistry::init('Denuncia');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Denuncia);

		parent::tearDown();
	}

}
