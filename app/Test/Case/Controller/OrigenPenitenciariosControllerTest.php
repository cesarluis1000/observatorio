<?php
App::uses('OrigenPenitenciariosController', 'Controller');

/**
 * OrigenPenitenciariosController Test Case
 */
class OrigenPenitenciariosControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.origen_penitenciario',
		'app.preso',
		'app.tipo_documento',
		'app.estab_penitenciario',
		'app.delito_especifico',
		'app.delito_generico'
	);

}
