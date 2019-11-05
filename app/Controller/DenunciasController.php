<?php
App::uses('AppController', 'Controller');
/**
 * Denuncias Controller
 *
 * @property Denuncia $Denuncia
 * @property PaginatorComponent $Paginator
 */
class DenunciasController extends AppController {

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
		$this->Denuncia->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->Denuncia->displayField)?$this->Denuncia->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['Denuncia'][$campo] = $nombre ;
			$conditions = array('conditions' => array('Denuncia.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('denuncias', $this->Paginator->paginate());
	}

	public function coordenadasjson(){	    
	    set_time_limit(108000);
	    ini_set('memory_limit','1024M');
	    
	    $options = array(//'fields'=>array('id','nro_denuncia','ubicacion','horizontal','vertical'),,'Denuncia.distrito_id'=>'811'
	        'conditions' => array(//'Denuncia.nro_denuncia'=>'15382481',
	            'estado_google IS NULL'
	        ),
	        //'recursive' => -1,
	        //'order' => array('nombdist')
	    );
	    
	    $denuncias = $this->Denuncia->find('all',$options);
	    
	    
	    $transaccion = true;
	    foreach ($denuncias as $denuncia){
	        //pr($denuncia['Denuncia']);
	        $direccion = $denuncia['Denuncia']['ubicacion'].' '.$denuncia['Distrito']['nombdist'].' '.$denuncia['Distrito']['nombprov'];
	        //pr($direccion);
	        
	        $direccion = str_replace(' ', '+', $direccion);        
            //&components=country:PE
	        //$url = "https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=YOUR_API_KEY";
	        //$url = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccion&components=country:PE&key=AIzaSyC7e2Iboim4HC-CfX2PmJR6BkSI8aSKb1U"; // Cesar
	        //$url = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccion&components=country:PE&key=AIzaSyB-Oeyt4yByMcCOc4rnCdw9_ml5XsIjOFc"; // Luis	        
	        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccion&components=country:PE&key=AIzaSyC6Hv9oFodbGJJ19gCy2XTj0mKCow7g-8Y"; // Kilder
	        //pr($url); 
	        //exit;
	        
	        $geo = file_get_contents($url);
	        
	        $geo = json_decode($geo, true); // Convert the JSON to an array
	        
	        if (isset($geo['status']) && ($geo['status'] == 'OK')) {	            
	            $denuncia['Denuncia']['vertical']          = $geo['results'][0]['geometry']['location']['lat']; // Latitude
	            $denuncia['Denuncia']['horizontal']        = $geo['results'][0]['geometry']['location']['lng']; // Longitude
	            $denuncia['Denuncia']['estado_google']     = $geo['status'];
	            $denuncia['Denuncia']['geom']              = null;
	            $denuncia['Denuncia']['ubicacion_google']  = $geo['results'][0]['formatted_address'];
	        }else{
	            $denuncia['Denuncia']['estado_google']    = 'KO';	            
	        }
	        //pr($denuncia['Denuncia']);
	        
	        if(!$this->Denuncia->save($denuncia['Denuncia'])){
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
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Denuncia->exists($id)) {
			throw new NotFoundException(__('Invalido(a) denuncia'));
		}
		$options = array('conditions' => array('Denuncia.' . $this->Denuncia->primaryKey => $id));
		$this->set('denuncia', $this->Denuncia->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Denuncia->create();
			if ($this->Denuncia->save($this->request->data)) {
				$this->Flash->success(__('El/la denuncia se ha guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('No se pudo guardar el/la denuncia. Por favor, int�ntelo de nuevo.'));
			}
		}
		$distritos = $this->Denuncia->Distrito->find('list');
		$this->set(compact('distritos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Denuncia->exists($id)) {
			throw new NotFoundException(__('Invalido(a) denuncia'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Denuncia->save($this->request->data)) {
				$this->Flash->success(__('El/la denuncia se ha guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('No se pudo guardar el/la denuncia. Por favor, int�ntelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Denuncia.' . $this->Denuncia->primaryKey => $id));
			$this->request->data = $this->Denuncia->find('first', $options);
		}
		$distritos = $this->Denuncia->Distrito->find('list');
		$this->set(compact('distritos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Denuncia->id = $id;
		if (!$this->Denuncia->exists()) {
			throw new NotFoundException(__('Invalid denuncia'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Denuncia->delete()) {
			$this->Flash->success(__('El/la denuncia ha sido borrado.'));
		} else {
			$this->Flash->error(__('El/la denuncia no ha sido borrado. Por favor int�ntelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
