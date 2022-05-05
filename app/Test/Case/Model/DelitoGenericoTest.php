<?php
App::uses('DelitoGenerico', 'Model');

/**
 * DelitoGenerico Test Case
 */
class DelitoGenericoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.delito_generico',
		'app.delito_especifico'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DelitoGenerico = ClassRegistry::init('DelitoGenerico');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DelitoGenerico);

		parent::tearDown();
	}

}
