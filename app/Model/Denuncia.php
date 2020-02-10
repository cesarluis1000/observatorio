<?php
App::uses('AppModel', 'Model');
/**
 * Denuncia Model
 *
 * @property Distrito $Distrito
 */
class Denuncia extends AppModel {

    public $virtualFields = array(
        'geojson' => "ST_AsGeoJSON(Denuncia.geom)"
    );
/**
 * Validation rules
 *
 * @var array
 */
	/*
	public $validate = array(
		'nro_denuncia' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'categoria' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'distrito_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
*/
	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Distrito' => array(
			'className' => 'Distrito',
			'foreignKey' => 'distrito_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	    'TipoDenuncia' => array(
	        'className' => 'TipoDenuncia',
	        'foreignKey' => 'tipo_denuncia_id',
	        'conditions' => '',
	        'fields' => '',
	        'order' => ''
	    )
	);
}
