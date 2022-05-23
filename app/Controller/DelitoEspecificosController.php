<?php
App::uses('AppController', 'Controller');
/**
 * DelitoEspecificos Controller
 *
 * @property DelitoEspecifico $DelitoEspecifico
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class DelitoEspecificosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->DelitoEspecifico->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->DelitoEspecifico->displayField)?$this->DelitoEspecifico->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){
		    $nombre = $this->request->query[$campo];
			$this->request->data['DelitoEspecifico'][$campo] = $nombre ;
			$conditions = array('conditions' => array('DelitoEspecifico.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('delitoEspecificos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DelitoEspecifico->exists($id)) {
			throw new NotFoundException(__('Invalid delito especifico'));
		}
		$options = array('conditions' => array('DelitoEspecifico.' . $this->DelitoEspecifico->primaryKey => $id));
		$this->set('delitoEspecifico', $this->DelitoEspecifico->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DelitoEspecifico->create();
			if ($this->DelitoEspecifico->save($this->request->data)) {
				$this->Flash->success(__('The delito especifico has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The delito especifico could not be saved. Please, try again.'));
			}
		}
		$delitoGenericos = $this->DelitoEspecifico->DelitoGenerico->find('list');
		$this->set(compact('delitoGenericos'));
	}

	public function listjson(){
	    $this->autoRender = false;
	    $this->response->type('json');

	    $delito_generico_id = $this->request->query['delito_generico_id'];

	    $options = array('fields'=>array('id','nombre'),
	        'conditions' => array(
				'delito_generico_id' => $delito_generico_id
			),
	        'recursive' => -1,
	        'order' => array('nombre')
		);


	    $de_especificos = $this->DelitoEspecifico->find('all',$options);
	    $json = json_encode($de_especificos);
	    $this->response->body($json);
	}


	/*Configurar cuadro de presos*/
	  public function presoschartjs(){
	    $this->layout = false;
	    $this->autoRender = false;
	    $this->loadModel('Preso');
	    $this->loadModel('TipoDocumento');

		$delito_generico_id = $this->request->query['delito_generico_id']; //generico

	    if (isset($this->request->query['delito_especifico_id']) && !empty($this->request->query['delito_especifico_id'])){ //especifico
	        $especifico_ids = $this->request->query['delito_especifico_id']; // especifico
	    }else{
	        /*
	         $options           = array('fields'=>array('DISTINCT distrito_id'),'recursive' => -1);
	         $polygon_activo    = $this->Distrito->DistPolygon->find('all',$options);
	         $distrito_ids      = Hash::extract($polygon_activo, '{n}.DistPolygon.distrito_id');
	         */
	        $options       = array('fields'=>array('id'),
                    	            'conditions'   =>  array('delito_generico_id' => $delito_generico_id), //generico
                    	            'recursive'    =>  -1);
	        $especificos_act = $this->DelitoEspecifico->find('all',$options);
	        $especifico_ids  = Hash::extract($especificos_act, '{n}.DelitoEspecifico.id'); //especifico

	    }


	    //No se esta conciderando OTROS y vIOLENCIA FAMILIAR
	    $presos = $this->TipoDocumento->find('all', array('fields'       => array('TipoDocumento.id','TipoDocumento.nombre'),
                                                	       'conditions'   => array('TipoDocumento.id' => array(1,2)),
	                                                       'recursive'   => -1
                                                	    ));

		//sit_juridi
		$sit_juridi = $this->request->query['sit_juridi'];

		if (isset($this->request->query['sit_juridi']) && !empty($this->request->query['sit_juridi'])){ //
	        $sit_juridico_ids = $this->request->query['sit_juridi']; //
	    }else{
	        /*
	         $options           = array('fields'=>array('DISTINCT distrito_id'),'recursive' => -1);
	         $polygon_activo    = $this->Distrito->DistPolygon->find('all',$options);
	         $distrito_ids      = Hash::extract($polygon_activo, '{n}.DistPolygon.distrito_id');
	         */
	        $options       = array('fields'=>array('id'),
                    	            'conditions'   =>  array('sit_juridi' => $sit_juridi), //
                    	            'recursive'    =>  -1);
	        $sit_juridicos_act = $this->Preso->find('all',$options);
	        $sit_juridico_ids  = Hash::extract($sit_juridicos_act, '{n}.Preso.id'); //

	    }

	    $datasets = array();

	    $backgroundColor   = array(
	        'RGBA(255,  255,   0, 0.2)', //YELLOW
	        'RGBA(255,    0, 255, 0.2)', //FUCHSIA
	        'RGBA(  0,  255, 255, 0.2)', //AQUA
	        'RGBA(  0,  128,   0, 0.2)', //GREEN
	        'RGBA(255,    0,   0, 0.2)', //RED
	        'RGBA(  0,    0, 255, 0.2)', //BLUE
	        'RGBA(128,    0,   0, 0.2)', //MAROON
	        'RGBA(128,    0, 128, 0.2)', //PURPLE
	        'RGBA(  0,    0,   0, 0.2)', //BLACK
	        'RGBA(  0,    0, 128, 0.2)', //NAVY
	        'RGBA(  0,  128, 128, 0.2)'); //TEAL

	    $borderColor       = array(
	        'RGBA(255, 255,    0, 0.8)', //YELLOW
	        'RGBA(255,   0,  255, 0.8)', //FUCHSIA
	        'RGBA(  0,  255, 255, 0.8)', //AQUA
	        'RGBA(  0,  128,   0, 0.8)', //GREEN
	        'RGBA(255,    0,   0, 0.8)', //RED
	        'RGBA(  0,    0, 255, 0.8)', //BLUE
	        'RGBA(128,    0,   0, 0.8)', //MAROON
	        'RGBA(128,    0, 128, 0.8)', //PURPLE
	        'RGBA(  0,    0,   0, 0.8)', //BLACK
	        'RGBA(  0,    0, 128, 0.8)', //NAVY
	        'RGBA(  0,  128, 128, 0.8)'); //TEAL

	    //pr($denuncias); exit;
	    /*pr($backgroundColor);
	    pr($borderColor);
	    pr($denuncias);
	    exit;*/
	    foreach ($presos as $i => $row){

	        $conditions    = array('Preso.tipo_documento_id'    => $row['TipoDocumento']['id'],
								   'Preso.fecha_ingreso BETWEEN ? AND ?'  => array('2021-01-01','2021-12-31'),
								   'Preso.delito_especifico_id' => $especifico_ids,
								   'Preso.sit_juridi' => $sit_juridico_ids,
								   'Preso.fecha_ingreso >='  =>  '2021-01-01',
								   //'Preso.sexo' => 'Masculino',
	                               //'MONTH(fecha_hecho)' => 1
								     //'Preso.fecha_ingreso >='  => '2017-01-01',
	                               );
	        $options       = array(
                	            'conditions' => $conditions,
	                            'fields'=>array('Preso.tipo_documento_id','YEAR(fecha_ingreso) as anio', 'MONTH(fecha_ingreso) as mes', 'COUNT(id) as preso_count'),
                	            //'joins' => array('LEFT JOIN `entities` AS Entity ON `Entity`.`category_id` = `Category`.`id`'),
	                            'group' => array('YEAR(fecha_ingreso)', 'MONTH(fecha_ingreso)'),'recursive'=>-1
                	            //'contain' => array('Domain' => array('fields' => array('title')))
                	        );

	        $preso_cant = $this->Preso->find('all', $options);

	        $data = Hash::extract($preso_cant, '{n}.0.preso_count');
	        $data = Hash::combine($preso_cant, '{n}.0.mes', '{n}.0.preso_count');
	        //pr($data);

	        $mes_fin = 9;
	        for ($mes_ini=1; $mes_ini <= $mes_fin; $mes_ini++){
	            if (!isset($data[$mes_ini])){
	                $data[$mes_ini] = 0;
	            }
	        }
	        ksort($data);
	        $data = implode(',',$data);
	        $data =  explode(',', $data);
	        //pr($data);

	        $datasets[$i]  = array('label'             =>  $row['TipoDocumento']['nombre'],
                    	            'fill'              =>  false,
	                                'backgroundColor'   =>  $backgroundColor[$i],
	                                'borderColor'       =>  $borderColor[$i],
	                                'hidden'            =>  ( in_array($row['TipoDocumento']['id'], array(1,2)))?false:true,
	                                'data'              =>  $data//array(881,734,786,670,761,780,669,885,415),
                    	        );
	    }

		/**Detalle de Cuadro Estadistico */
	    $presos2 = array(  'type'      => 'line',
	        'data'      =>  array(  'labels' => array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'),
	            'datasets'  =>  $datasets
	        ),
	        'options'   =>  array(  'responsive'    => true,
	            'title'         => array(   'display'   =>  true,
	                'text'      =>  'Cuadro Estadistico'),
	            'tooltips'      => array(   'mode'      =>  'index',
	                'intersect' =>  false),
	            'hover'         => array(   'mode'      =>  'nearest',
	                'intersect' =>  true),
	            'scales'        =>  array(  'xAxes'     => array(array( 'display'       =>  true,
	                'scaleLabel'    =>  array(  'display'       =>  true,
	                    'labelString'   =>  'Meses')
	            )
	            ),
	                'yAxes'     => array(array( 'display'       =>  true,
	                    'scaleLabel'    =>  array(  'display'       =>  true,
	                        'labelString'   =>  'Valor')
	                )
	                )
	            )
	        )
	    );
	    //pr($delitos2);
	    //pr($delitos2);exit;
	    //$json = json_encode($delitos);
	    $json = json_encode($presos2);
	    $this->response->body($json);
	}


/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->DelitoEspecifico->exists($id)) {
			throw new NotFoundException(__('Invalid delito especifico'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DelitoEspecifico->save($this->request->data)) {
				$this->Flash->success(__('The delito especifico has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The delito especifico could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DelitoEspecifico.' . $this->DelitoEspecifico->primaryKey => $id));
			$this->request->data = $this->DelitoEspecifico->find('first', $options);
		}
		$delitoGenericos = $this->DelitoEspecifico->DelitoGenerico->find('list');
		$this->set(compact('delitoGenericos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->DelitoEspecifico->id = $id;
		if (!$this->DelitoEspecifico->exists()) {
			throw new NotFoundException(__('Invalid delito especifico'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->DelitoEspecifico->delete()) {
			$this->Flash->success(__('The delito especifico has been deleted.'));
		} else {
			$this->Flash->error(__('The delito especifico could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
