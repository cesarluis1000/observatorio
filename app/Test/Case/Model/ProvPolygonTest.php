<?php
App::uses('ProvPolygon', 'Model');

/**
 * ProvPolygon Test Case
 */
class ProvPolygonTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.prov_polygon',
		'app.provincia',
		'app.departamento',
		'app.dep_polygon'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProvPolygon = ClassRegistry::init('ProvPolygon');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProvPolygon);

		parent::tearDown();
	}

}
