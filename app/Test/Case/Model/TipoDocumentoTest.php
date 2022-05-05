<?php
App::uses('TipoDocumento', 'Model');

/**
 * TipoDocumento Test Case
 */
class TipoDocumentoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.tipo_documento',
		'app.preso'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TipoDocumento = ClassRegistry::init('TipoDocumento');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TipoDocumento);

		parent::tearDown();
	}

}
