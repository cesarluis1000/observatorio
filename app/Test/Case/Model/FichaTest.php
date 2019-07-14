<?php
App::uses('Ficha', 'Model');

/**
 * Ficha Test Case
 */
class FichaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ficha'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ficha = ClassRegistry::init('Ficha');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ficha);

		parent::tearDown();
	}

}
