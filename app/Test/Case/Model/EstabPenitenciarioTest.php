<?php
App::uses('EstabPenitenciario', 'Model');

/**
 * EstabPenitenciario Test Case
 */
class EstabPenitenciarioTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.estab_penitenciario',
		'app.preso'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->EstabPenitenciario = ClassRegistry::init('EstabPenitenciario');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EstabPenitenciario);

		parent::tearDown();
	}

}
