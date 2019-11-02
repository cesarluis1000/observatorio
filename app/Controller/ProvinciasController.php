<?php
App::uses('AppController', 'Controller');
/**
 * Provincias Controller
 *
 * @property Provincia $Provincia
 * @property PaginatorComponent $Paginator
 */
class ProvinciasController extends AppController {

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
		$this->Provincia->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->Provincia->displayField)?$this->Provincia->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['Provincia'][$campo] = $nombre ;
			$conditions = array('conditions' => array('Provincia.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('provincias', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Provincia->exists($id)) {
			throw new NotFoundException(__('Invalido(a) provincia'));
		}
		$options = array('conditions' => array('Provincia.' . $this->Provincia->primaryKey => $id));
		$this->set('provincia', $this->Provincia->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Provincia->create();
			if ($this->Provincia->save($this->request->data)) {
				$this->Flash->success(__('El/la provincia se ha guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('No se pudo guardar el/la provincia. Por favor, int�ntelo de nuevo.'));
			}
		}
		$departamentos = $this->Provincia->Departamento->find('list');
		$this->set(compact('departamentos'));
	}
	
	public function listjson(){
	    $this->autoRender = false;
	    $this->response->type('json');
	    
	    $departamento_id = $this->request->query['departamento_id'];
	    
	    $options = array('fields'=>array('id','first_idpr','first_nomb','nombprov','ha'),
	        'conditions' => array('departamento_id' => $departamento_id),
	        'recursive' => -1,
	        'order' => array('nombprov'));
	    
	    if (isset($this->request->query['provincia_id'])){
	        $provincia_id = $this->request->query['provincia_id'];
	        $options['conditions']['id'] = $provincia_id;
	    }
	    
	    $provincias = $this->Provincia->find('all',$options);
	    $json = json_encode($provincias);
	    $this->response->body($json);
	}

	/**
	 * add geojson
	 *
	 * @return void
	 */
	public function geojson() {
	    $this->autoRender = false;
	    $this->response->type('json');
	    
	    $departamento_id = $this->request->query['departamento_id'];
	    
	    $options = array('fields'=>array('id','first_idpr','first_nomb','nombprov','ha','ST_AsGeoJSON(geom) AS geometry'),
            	        'conditions' => array('departamento_id' => $departamento_id),
            	        'recursive' => -1);
	    
	    if (isset($this->request->query['provincia_id']) && !empty($this->request->query['provincia_id'])){
	        $options['conditions']['id'] = $this->request->query['provincia_id'];
	    }
	    
	    $provincias = $this->Provincia->find('all',$options);
	    
	    foreach ($provincias as $i => $row){
	        $provincias[$i]['type'] = 'Feature';
	        $provincias[$i]['properties'] = $row['Provincia'];	
	        
	        if (!empty($row[0]['geometry'])){
	            $provincias[$i]['geometry'] = $row[0]['geometry'];
	        }else{
	            $options = array('fields'=>array('id','horizontal','vertical'),
	                'conditions'=>array('ProvPolygon.provincia_id' => $row['Provincia']['id']),
	                'recursive' => -1
	            );
	            $polygon = $this->Provincia->ProvPolygon->find('all',$options);
	            $cordenada=null;
	            foreach ($polygon as $pol){
	                $cordenada[] = '['.$pol['ProvPolygon']['horizontal'].','.$pol['ProvPolygon']['vertical'].']';
	            }
	            
	            $provincias[$i]['geometry'] = array('type' => 'Polygon',"coordinates"=>array(array(implode($cordenada, ','))));
	        }	        
	        
	        unset($provincias[$i]['Provincia']);
	        unset($provincias[$i][0]);
	    }
	    
	    $provincias = array('type' => 'FeatureCollection','features'=>$provincias);
	    $json = json_encode($provincias);
	    $json = str_replace('[["[', '[[[', $json);
	    $json = str_replace(']"]]', ']]]', $json);
	    
	    $json = str_replace(':"{', ':{', $json);
	    $json = str_replace('}"}', '}}', $json);
	    $json = str_replace('\\', '', $json);
	    
	    $this->response->body($json);
	}
	
	public function geometry(){
	    $this->layout = false;
	    $this->autoRender = false;
	    //$this->response->type('json')
	    $departamento_id = $this->request->query['departamento_id'];
	    
	    $options = array('fields'=>array('id','first_idpr','first_nomb','nombprov','ha','ST_AsGeoJSON(geom) AS geometry'),
            	        'conditions' => array('departamento_id' => $departamento_id),
            	        'recursive' => -1);
	    
	    if (isset($this->request->query['provincia_id']) && !empty($this->request->query['provincia_id'])){
	        $options['conditions']['id'] = $this->request->query['provincia_id'];
	    }
	    
	    $provincias = $this->Provincia->find('all',$options);
	    //pr($distritos);
	    $poligonos = null;
	    foreach ($provincias as $i => $row){
	        
	        $options = array('fields'      =>  array('id','vertical','horizontal'),
            	            'conditions'   =>  array('ProvPolygon.provincia_id' => $row['Provincia']['id']),
            	            'recursive'    =>  -1
            	        );
	        
	        $polygon   =   $this->Provincia->ProvPolygon->find('all',$options);
	        $cordenada =   null;
	        
	        foreach ($polygon as $pol){
	            $cordenada[] = $pol['ProvPolygon']['horizontal'].' '.$pol['ProvPolygon']['vertical'];
	        }
	        
	        if (empty($cordenada)){
	            unset($provincias[$i]);
	            continue;
	        }
	        unset($provincias[$i]['Provincia']);
	        $poligonos .= "UPDATE provincias SET geom = ST_GeomFromText('POLYGON((".implode($cordenada, ',')."))') WHERE id = ".$row['Provincia']['id'].';<br>';
	        
	    }
	    pr($poligonos);
	    $this->response->body();
	    
	}
	
	/**
	 * addjson method
	 *
	 * @return void
	 */
	public function addjson() {
	    if ($this->request->is('post')) {	        
	        $datajson = json_decode($this->request->data['Provincia']['datajson']);
	        
	        unset($this->request->data['Provincia']);
	        
	        $transaccion = true;
	        foreach ($datajson->features as $i=> $dep){	            
	            
	            $options = array('conditions' => array('nombdep' => $dep->properties->FIRST_NOMB),
	                             'recursive' => -1
	                            );
	            $departamento = $this->Provincia->Departamento->find('first',$options);
	            
	            $first_fech = explode('/', $dep->properties->FIRST_FECH);	            
	            if (isset($first_fech[2])){
	                $first_fech2 = array_reverse($first_fech);
	                $first_fech3 = implode('-', $first_fech2);
	            }else{
	                $first_fech3 = null;
	            }
	            
	            $last_fecha = explode('/', $dep->properties->LAST_FECHA);
	            if (isset($last_fecha[2])){
	                $last_fecha2 = array_reverse($last_fecha);
	                $last_fecha3 = implode('-', $last_fecha2);
	            }else{
	                $last_fecha3 = null;
	            }
	            
	            $this->request->data[$i]['Provincia']['first_idpr']        = $dep->properties->FIRST_IDPR;
	            $this->request->data[$i]['Provincia']['nombprov']          = $dep->properties->NOMBPROV;
	            $this->request->data[$i]['Provincia']['first_nomb']        = $dep->properties->FIRST_NOMB;
	            $this->request->data[$i]['Provincia']['departamento_id']   = $departamento['Departamento']['id'];
	            $this->request->data[$i]['Provincia']['last_dcto']         = $dep->properties->LAST_DCTO;
	            $this->request->data[$i]['Provincia']['last_ley']          = $dep->properties->LAST_LEY;	            
	            $this->request->data[$i]['Provincia']['first_fech']        = $first_fech3;
	            $this->request->data[$i]['Provincia']['last_fecha']        = $last_fecha3;
	            $this->request->data[$i]['Provincia']['min_shape']         = $dep->properties->MIN_SHAPE_;
	            $this->request->data[$i]['Provincia']['ha']                = $dep->properties->ha;
	            $this->request->data[$i]['Provincia']['count']                = $dep->properties->COUNT;
	            
	            $this->Provincia->create();
	            if(!$this->Provincia->save($this->request->data[$i]['Provincia'])){
	                $transaccion = false;
	                break;
	            }
	            $provincia_id = $this->Provincia->getLastInsertId();
	            
	            
	            if (($dep->geometry->type == 'MultiPolygon')){
	                unset($dep->geometry->coordinates[0]);
	                unset($dep->geometry->coordinates[1][1]);
	                $DepPolygons = Hash::extract($dep->geometry->coordinates, '{n}.{n}');
	            }else{
	                $DepPolygons = Hash::extract($dep->geometry->coordinates, '{n}');
	            }

	            //$DepPolygons = Hash::extract($dep->geometry->coordinates, '{n}');
	            foreach ($DepPolygons[0] as $j=> $pol){
	                $this->request->data[$i]['Provincia']['ProvPolygon'][$j]['provincia_id'] = $provincia_id;
	                $this->request->data[$i]['Provincia']['ProvPolygon'][$j]['horizontal'] = $pol[0];
	                $this->request->data[$i]['Provincia']['ProvPolygon'][$j]['vertical'] = $pol[1];
	                $this->Provincia->ProvPolygon->create();
	                if (!$this->Provincia->ProvPolygon->save($this->request->data[$i]['Provincia']['ProvPolygon'][$j])) {
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
	            $this->Flash->success(__('El/la Provincia se ha guardado.'));
	            return $this->redirect(array('action' => 'index'));
	        }else{
	            $this->Flash->error(__('No se pudo guardar el/la Provincia. Por favor, intentelo de nuevo.'));
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
		if (!$this->Provincia->exists($id)) {
			throw new NotFoundException(__('Invalido(a) provincia'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Provincia->save($this->request->data)) {
				$this->Flash->success(__('El/la provincia se ha guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('No se pudo guardar el/la provincia. Por favor, int�ntelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Provincia.' . $this->Provincia->primaryKey => $id));
			$this->request->data = $this->Provincia->find('first', $options);
		}
		$departamentos = $this->Provincia->Departamento->find('list');
		$this->set(compact('departamentos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Provincia->id = $id;
		if (!$this->Provincia->exists()) {
			throw new NotFoundException(__('Invalid provincia'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Provincia->delete()) {
			$this->Flash->success(__('El/la provincia ha sido borrado.'));
		} else {
			$this->Flash->error(__('El/la provincia no ha sido borrado. Por favor int�ntelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
