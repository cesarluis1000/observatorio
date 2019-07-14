<?php
App::uses('TipoInstitucion', 'Model');

/**
 * TipoInstitucion Test Case
 */
class TipoInstitucionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.tipo_institucion',
		'app.institucion'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TipoInstitucion = ClassRegistry::init('TipoInstitucion');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TipoInstitucion);

		parent::tearDown();
	}

}
