<?php
App::uses('DelitoEspecifico', 'Model');

/**
 * DelitoEspecifico Test Case
 */
class DelitoEspecificoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.delito_especifico',
		'app.delito_generico',
		'app.preso'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DelitoEspecifico = ClassRegistry::init('DelitoEspecifico');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DelitoEspecifico);

		parent::tearDown();
	}

}
