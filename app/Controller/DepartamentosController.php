<?php
App::uses('AppController', 'Controller');
/**
 * Departamentos Controller
 *
 * @property Departamento $Departamento
 * @property PaginatorComponent $Paginator
 */
class DepartamentosController extends AppController {

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
		$this->Departamento->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->Departamento->displayField)?$this->Departamento->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['Departamento'][$campo] = $nombre ;
			$conditions = array('conditions' => array('Departamento.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('departamentos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Departamento->exists($id)) {
			throw new NotFoundException(__('Invalido(a) departamento'));
		}
		$options = array('conditions' => array('Departamento.' . $this->Departamento->primaryKey => $id));
		$this->set('departamento', $this->Departamento->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Departamento->create();
			if ($this->Departamento->save($this->request->data)) {
				$this->Flash->success(__('El/la departamento se ha guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('No se pudo guardar el/la departamento. Por favor, int�ntelo de nuevo.'));
			}
		}
	}
	
	/**
	 * add geojson
	 *
	 * @return void
	 */
	public function geojson() {
	    $this->autoRender = false;
	    $this->response->type('json');
	    	       
	    $options = array('fields'=>array('id','first_iddp','nombdep','hectares'),
	                     'recursive' => -1);
	    
	    if (isset($this->request->query['departamento_id'])){
	        $departamento_id = $this->request->query['departamento_id'];
	        $options['conditions']['id'] = $departamento_id;
	        //$conditions = array('conditions' => array('id' => $departamento_id));
	        //$options = array_merge($options,$conditions);
	    }
	    
	    $departamentos = $this->Departamento->find('all',$options);
	    foreach ($departamentos as $i => $dep){
	        $options = array('fields'=>array('id','horizontal','vertical'),
	                         'conditions'=>array('DepPolygon.departamento_id' => $dep['Departamento']['id']),
	                         'recursive' => -1
	                         );
	        $DepPolygon = $this->Departamento->DepPolygon->find('all',$options);
	        $cordenada=null;
	        foreach ($DepPolygon as $pol){
	            $cordenada[] = '['.$pol['DepPolygon']['horizontal'].','.$pol['DepPolygon']['vertical'].']';
	        }
	        //$coordinates = Hash::combine($DepPolygon,'{n}.DepPolygon.id',array('%s, %s', '{n}.DepPolygon.horizontal', '{n}.DepPolygon.vertical'),'{n}.DepPolygon.id');
	        $departamentos[$i]['type'] = 'Feature';
	        $departamentos[$i]['properties'] = $dep['Departamento'];
	        unset($departamentos[$i]['Departamento']);
	        $departamentos[$i]['geometry'] = array('type' => 'Polygon',"coordinates"=>array(array(implode($cordenada, ','))));
	    }
	    $departamentos = array('type' => 'FeatureCollection','features'=>$departamentos);
	    $json = json_encode($departamentos);
	    $json = str_replace('[["[', '[[[', $json);
	    $json = str_replace(']"]]', ']]]', $json);
	    $this->response->body($json);;
	}

/**
 * addjson method
 *
 * @return void
 */
	public function addjson() {
	    if ($this->request->is('post')) {
	        $datajson = json_decode($this->request->data['Departamento']['datajson']);
	        //$data = Hash::extract($datajson->features, '{n}.properties');
	        //Hash::extract($datajson->features, '{n}.geometry');
	        unset($this->request->data['Departamento']);
	        
	        $transaccion = true;
	        foreach ($datajson->features as $i=> $dep){
	            $this->request->data[$i]['Departamento']['first_iddp'] = $dep->properties->FIRST_IDDP;
	            $this->request->data[$i]['Departamento']['nombdep']    = $dep->properties->NOMBDEP;
	            $this->request->data[$i]['Departamento']['count']      = $dep->properties->COUNT;
	            $this->request->data[$i]['Departamento']['hectares']   = $dep->properties->HECTARES;
	            
	            $this->Departamento->create();
	            if(!$this->Departamento->save($this->request->data[$i]['Departamento'])){
	                $transaccion = false;
	                break;
	            }
	            $departamento_id = $this->Departamento->getLastInsertId();
	            	            
	            if (($dep->geometry->type == 'MultiPolygon')){
	                unset($dep->geometry->coordinates[0]);
	                unset($dep->geometry->coordinates[1][1]);
	                $DepPolygons = Hash::extract($dep->geometry->coordinates, '{n}.{n}');
	            }else{
	                $DepPolygons = Hash::extract($dep->geometry->coordinates, '{n}');
	            }
	            
	            foreach ($DepPolygons[0] as $j=> $pol){
	                $this->request->data[$i]['Departamento']['DepPolygon'][$j]['departamento_id'] = $departamento_id;
	                $this->request->data[$i]['Departamento']['DepPolygon'][$j]['horizontal'] = $pol[0];
	                $this->request->data[$i]['Departamento']['DepPolygon'][$j]['vertical'] = $pol[1];
	                $this->Departamento->DepPolygon->create();
	                if (!$this->Departamento->DepPolygon->save($this->request->data[$i]['Departamento']['DepPolygon'][$j])) {
	                    $transaccion = false;
	                    break;
	                }else{
	                    $transaccion = true;
	                }
	            }
	            
	            if (!$transaccion){
	                break;
	            }
	        }
	        
	        if ($transaccion){
	            $this->Flash->success(__('El/la departamento se ha guardado.'));
	            return $this->redirect(array('action' => 'index'));
	        }else{
	            $this->Flash->error(__('No se pudo guardar el/la departamento. Por favor, inténtelo de nuevo.'));
	        }
	        
	    }
	}
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Departamento->exists($id)) {
			throw new NotFoundException(__('Invalido(a) departamento'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Departamento->save($this->request->data)) {
				$this->Flash->success(__('El/la departamento se ha guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('No se pudo guardar el/la departamento. Por favor, int�ntelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Departamento.' . $this->Departamento->primaryKey => $id));
			$this->request->data = $this->Departamento->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Departamento->id = $id;
		if (!$this->Departamento->exists()) {
			throw new NotFoundException(__('Invalid departamento'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Departamento->delete()) {
			$this->Flash->success(__('El/la departamento ha sido borrado.'));
		} else {
			$this->Flash->error(__('El/la departamento no ha sido borrado. Por favor int�ntelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
