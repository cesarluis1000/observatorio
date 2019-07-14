<?php
App::uses('Distrito', 'Model');

/**
 * Distrito Test Case
 */
class DistritoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
		$this->Distrito = ClassRegistry::init('Distrito');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Distrito);

		parent::tearDown();
	}

}
