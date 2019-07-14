<?php
App::uses('DepPolygon', 'Model');

/**
 * DepPolygon Test Case
 */
class DepPolygonTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.dep_polygon',
		'app.departamento'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DepPolygon = ClassRegistry::init('DepPolygon');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DepPolygon);

		parent::tearDown();
	}

}
