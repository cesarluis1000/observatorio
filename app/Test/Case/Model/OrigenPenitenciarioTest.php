<?php
App::uses('OrigenPenitenciario', 'Model');

/**
 * OrigenPenitenciario Test Case
 */
class OrigenPenitenciarioTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.origen_penitenciario',
		'app.preso'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->OrigenPenitenciario = ClassRegistry::init('OrigenPenitenciario');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OrigenPenitenciario);

		parent::tearDown();
	}

}
