<?php
App::uses('Preso', 'Model');

/**
 * Preso Test Case
 */
class PresoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.preso',
		'app.tipo_documento',
		'app.estab_penitenciario',
		'app.delito_especifico',
		'app.delito_generico',
		'app.origen_penitenciario'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Preso = ClassRegistry::init('Preso');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Preso);

		parent::tearDown();
	}

}
