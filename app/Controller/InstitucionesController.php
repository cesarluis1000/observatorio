<?php
App::uses('AppController', 'Controller');
/**
 * Instituciones Controller
 *
 * @property Institucion $Institucion
 * @property PaginatorComponent $Paginator
 */
class InstitucionesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Institucion->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->Institucion->displayField)?$this->Institucion->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['Institucion'][$campo] = $nombre ;
			$conditions = array('conditions' => array('Institucion.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('instituciones', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Institucion->exists($id)) {
			throw new NotFoundException(__('Invalid institucion'));
		}
		$options = array('conditions' => array('Institucion.' . $this->Institucion->primaryKey => $id));
		$this->set('institucion', $this->Institucion->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Institucion->create();
			if ($this->Institucion->save($this->request->data)) {
				$this->Flash->success(__('The institucion has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The institucion could not be saved. Please, try again.'));
			}
		}
		$tipoinstituciones = $this->Institucion->TipoInstitucion->find('list');
		$this->set(compact('tipoinstituciones'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Institucion->exists($id)) {
			throw new NotFoundException(__('Invalid institucion'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Institucion->save($this->request->data)) {
				$this->Flash->success(__('The institucion has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The institucion could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Institucion.' . $this->Institucion->primaryKey => $id));
			$this->request->data = $this->Institucion->find('first', $options);
		}
		$tipoinstituciones = $this->Institucion->TipoInstitucion->find('list');
		$this->set(compact('tipoinstituciones'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Institucion->id = $id;
		if (!$this->Institucion->exists()) {
			throw new NotFoundException(__('Invalid institucion'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Institucion->delete()) {
			$this->Flash->success(__('The institucion has been deleted.'));
		} else {
			$this->Flash->error(__('The institucion could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	public function coordenadasjson(){
	    set_time_limit(108000);
	    ini_set('memory_limit','1024M');
	    
	    $options = array(//'fields'=>array('id','nro_denuncia','ubicacion','horizontal','vertical'),,'Denuncia.distrito_id'=>'811'
	        'conditions' => array('estado_google IS NULL',
	                              'tipo_institucion_id NOT IN'=> array('3','4'),
	            //'Institucion.id'     => '2314'
	                           ),
	        //'recursive' => -1,
	        //'order' => array('nombdist')
	    );
	    $this->Institucion->unbindModel(array('belongsTo'=>array('TipoDenuncia','TipoInstitucion')));
	    $instituciones = $this->Institucion->find('all',$options);
	    
	    //pr($instituciones); exit;
	    
	    $transaccion = true;
	    foreach ($instituciones as $institucion){
	        //pr($denuncia['Denuncia']);
	        $direccion = $institucion['Institucion']['ubicacion'].' '.$institucion['Distrito']['nombdist'].' '.$institucion['Distrito']['nombprov'];
	        //pr($direccion); exit;
	        
	        $direccion = str_replace(' ', '+', $direccion);
	        
	        //$url = "https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=YOUR_API_KEY";
	        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccion&key=AIzaSyC7e2Iboim4HC-CfX2PmJR6BkSI8aSKb1U";
	        //pr($url); exit;
	        $geo = file_get_contents($url);
	        
	        $geo = json_decode($geo, true); // Convert the JSON to an array
	        //pr($geo); exit;
	        if (isset($geo['status']) && ($geo['status'] == 'OK')) {
	            $institucion['Institucion']['latitud']          = $geo['results'][0]['geometry']['location']['lat']; // Latitude
	            $institucion['Institucion']['longitud']        = $geo['results'][0]['geometry']['location']['lng']; // Longitude
	            $institucion['Institucion']['estado_google']     = $geo['status'];
	            $institucion['Institucion']['ubicacion_google']  = $geo['results'][0]['formatted_address'];
	        }else{
	            $institucion['Institucion']['estado_google']    = 'KO';
	        }
	        //pr($institucion['Institucion']);
	        //exit;
	        
	        if(!$this->Institucion->save($institucion['Institucion'])){
	            //debug($this->Institucion->validationErrors);  exit;
	            $transaccion = false;
	            break;
	        }
	    }
	    
	    if ($transaccion){
	        $this->Flash->success(__('Las coordenadas de las denuncias se ha guardado.'));
	    }else{
	        $this->Flash->error(__('No se pudo guardar la denuncia. Por favor, inténtelo de nuevo.'));
	    }
	    
	}
}
