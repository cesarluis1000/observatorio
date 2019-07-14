<?php
App::uses('DistPolygon', 'Model');

/**
 * DistPolygon Test Case
 */
class DistPolygonTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.dist_polygon',
		'app.distrito',
		'app.provincia',
		'app.departamento',
		'app.dep_polygon',
		'app.prov_polygon'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DistPolygon = ClassRegistry::init('DistPolygon');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DistPolygon);

		parent::tearDown();
	}

}
