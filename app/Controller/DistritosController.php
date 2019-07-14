<?php
App::uses('AppController', 'Controller');
/**
 * Distritos Controller
 *
 * @property Distrito $Distrito
 * @property PaginatorComponent $Paginator
 */
class DistritosController extends AppController {

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
		$this->Distrito->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->Distrito->displayField)?$this->Distrito->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['Distrito'][$campo] = $nombre ;
			$conditions = array('conditions' => array('Distrito.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('distritos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Distrito->exists($id)) {
			throw new NotFoundException(__('Invalido(a) distrito'));
		}
		$options = array('conditions' => array('Distrito.' . $this->Distrito->primaryKey => $id));
		$this->set('distrito', $this->Distrito->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Distrito->create();
			if ($this->Distrito->save($this->request->data)) {
				$this->Flash->success(__('El/la distrito se ha guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('No se pudo guardar el/la distrito. Por favor, int�ntelo de nuevo.'));
			}
		}
		$provincias = $this->Distrito->Provincium->find('list');
		$this->set(compact('provincias'));
	}
	
	public function listjson(){
	    $this->autoRender = false;
	    $this->response->type('json');
	    
	    $provincia_id = $this->request->query['provincia_id'];
	   	    
	    $options = array('fields'=>array('id','iddist','nombdist','nombprov','area_minam'),
	        'conditions' => array('provincia_id' => $provincia_id),
	        'recursive' => -1,
	        'order' => array('nombdist')
	    );
	    
	    if (isset($this->request->query['distrito_id'])){
	        $distrito_id = $this->request->query['distrito_id'];
	        $options['conditions']['id'] = $distrito_id;
	    }
	    
	    $distritos = $this->Distrito->find('all',$options);
	    $json = json_encode($distritos);
	    $this->response->body($json);
	}
	
	public function institucionesgeojson(){
	    $this->autoRender = false;
	    $this->response->type('json');	   
	    $this->loadModel('Institucion');
	    $this->loadModel('Provincia');
	    
	    //Obtenemos el departamento o departamento del PERU
	    if (isset($this->request->query['departamento_id'])){
	        $departamento_id = $this->request->query['departamento_id'];
	    }else{
	        $departamento_id = 0;
	    }
	    //$provincia_id = $this->request->query['provincia_id'];
	    
	    //Obtenemos la provincia o provincias de los DEPARTAMENTO
	    if (isset($this->request->query['provincia_id'])){
	        $provincia_ids     = $this->request->query['provincia_id'];
	    }else{
	        $options           = array('fields'     => array('DISTINCT id'),
	            'conditions'   =>  array('departamento_id' => $departamento_id),
	            'recursive'  => -1);
	        $provincias_act    = $this->Distrito->Provincia->find('all',$options);
	        $provincia_ids     = Hash::extract($provincias_act, '{n}.Provincia.id');
	    }
	    
	    //Obtenemos el distrito o distritos si es por PROVINCIA
	    if (isset($this->request->query['distrito_id'])){
	        $distrito_ids      = $this->request->query['distrito_id'];
	    }else{
	        $options           = array('fields'     =>  array('DISTINCT id'),
	            'conditions' =>  array('provincia_id' => $provincia_ids),
	            'recursive'  =>  -1);
	        $polygon_activo    = $this->Distrito->find('all',$options);
	        $distrito_ids      = Hash::extract($polygon_activo, '{n}.Distrito.id');
	    }
	    
	    //pr($provincia_ids);
	    $options = array('fields'=>array('id','iddist','nombdist','nombprov','area_minam'),
	        'conditions' => array('provincia_id' => $provincia_ids, 'Distrito.id' => $distrito_ids)
	        //,'limit' => 2
	        ,'recursive' => -1
	    );
	    
	    //Quitamos la relaccion del perimetro del distritos
	    //$this->Distrito->unbindModel(array('hasMany'=>array('DistPolygon','Denuncia')));
	    
	    $distritos = $this->Distrito->find('all',$options);
	    
	    $delitos = null;
	    foreach ($distritos as $i => $distrito){
	        
	        $conditions = array('Institucion.distrito_id' => $distrito['Distrito']['id'],);
	        
	        $options = array(//'fields'=>array('id','latitud','longitud','creador'),
	            'conditions'=> $conditions,
	            //'recursive' => -1,
	            //'limit' => 2,
	            'order' => array('Institucion.creador DESC'),
	        );
	        
	        $polygon = $this->Institucion->find('all',$options);
	        
	        $a_institucion=null;
	        
	        foreach ($polygon as $pol){
	            $a_institucion[$pol['TipoInstitucion']['institucion']][] = '['.$pol['Institucion']['longitud'].','.$pol['Institucion']['latitud'].']';
	        }
	        
	        if (empty($a_institucion)){
	            unset($distritos[$i]);
	            continue;
	        }
	        
	        foreach ($a_institucion as $tipoInstitucion => $institucionCoordenadas ){
	            $delitos[] = array('institucion'   => $tipoInstitucion.'60px.png',
	                'type'     => 'Feature',
	                'geometry' => array('type'        =>  'Polygon',
	                    'coordinates' =>  array(array(implode($institucionCoordenadas, ','))))
	            );
	        }
	        
	    }
	    
	    $delitos = array('type' => 'FeatureCollection','features'=>$delitos);
	    
	    //pr($delitos);exit;
	    $json = json_encode($delitos);
	    $json = str_replace('[["[', '[[[', $json);
	    $json = str_replace(']"]]', ']]]', $json);
	    $this->response->body($json);;
	}
	
	public function delitosgeojson() {
	    $this->layout = false;
	    $this->autoRender = false;
	    //$this->response->type('json');	    	    
	    
	    //Obtenemos el departamento o departamento del PERU
	    if (isset($this->request->query['departamento_id'])){
	        $departamento_id = $this->request->query['departamento_id'];	       
	    }else{
	        $departamento_id = 0;
	    }
	    
	    //Obtenemos la provincia o provincias de los DEPARTAMENTO
	    if (isset($this->request->query['provincia_id'])){
	        $provincia_ids     = $this->request->query['provincia_id'];
	    }else{
	        $options           = array('fields'     => array('DISTINCT id'),
	            'conditions'   =>  array('departamento_id' => $departamento_id),
	            'recursive'  => -1);
	        $provincias_act    = $this->Distrito->Provincia->find('all',$options);
	        $provincia_ids     = Hash::extract($provincias_act, '{n}.Provincia.id');	        
	    }
	    
	    //Obtenemos el distrito o distritos si es por PROVINCIA
	    if (isset($this->request->query['distrito_id'])){
	        $distrito_ids      = $this->request->query['distrito_id'];
	    }else{
	        $options           = array('fields'     =>  array('DISTINCT id'),
	                                   'conditions' =>  array('provincia_id' => $provincia_ids),
	                                   'recursive'  =>  -1);
	        $polygon_activo    = $this->Distrito->find('all',$options);
	        $distrito_ids      = Hash::extract($polygon_activo, '{n}.Distrito.id');
	    }
	    
	    $options = array(  'fields'       =>  array('id','iddist','nombdist','nombprov','area_minam'),
	                       'conditions'   =>  array('provincia_id' => $provincia_ids, 'Distrito.id' => $distrito_ids),
            	           'recursive'    =>  -1);
	    
	    //Quitamos la relaccion del perimetro del distritos
	    $this->Distrito->unbindModel(array('hasMany'=>array('DistPolygon')));
	    
	    $distritos = $this->Distrito->find('all',$options);
	    //pr($distritos);exit;
	    $delitos = null;
	    foreach ($distritos as $i => $distrito){
	        
	        $conditions = array('Denuncia.distrito_id' => $distrito['Distrito']['id'],
	                            'Denuncia.estado_google' => 'OK',	            
	                           );
	        
	        //Si exite la categoria del delito los asiginamos
	        if (isset($this->request->query['delito'])){	            
	            $delito = $this->request->query['delito'];
	            $a_delito = array_keys($delito);
	            $conditions = array_merge($conditions,array("replace(categoria,' ','_')" => $a_delito));
	        }
	        
	        if (isset($this->request->query['fecha_de'])){
	            $fecha_de = $this->request->query['fecha_de'];
	            $conditions = array_merge($conditions,array("fecha_hecho >=" => $fecha_de));
	        }
	        
	        if (isset($this->request->query['hasta'])){
	            $fecha_hasta = $this->request->query['hasta'];
	            $conditions = array_merge($conditions,array("fecha_hecho <=" => $fecha_hasta));
	        }
	        
	        if (isset($this->request->query['horas'])){
	            $horas1 = $this->request->data['Reportes']['horas1'] = $this->request->query['horas1'];
	            $horas2 = $this->request->data['Reportes']['horas2'] = $this->request->query['horas2'];
	            
	            $conditions = array_merge($conditions,array("HOUR(fecha_hecho) >=" => $horas1));
	            $conditions = array_merge($conditions,array("HOUR(fecha_hecho) <=" => $horas2));
	        }
	        
	        $options = array('fields'=>array('id','horizontal','vertical','categoria'),
	            'conditions'=> $conditions,
	            'recursive' => -1,
	            'order' => array('categoria DESC'),
	        );
	        
	        $polygon = $this->Distrito->Denuncia->find('all',$options);
	        //pr($polygon);
	        $cordenada=null;
	        $a_delitos=null;
	        foreach ($polygon as $pol){
	            $cordenada[] = '['.$pol['Denuncia']['horizontal'].','.$pol['Denuncia']['vertical'].']';
	            $a_delitos[$pol['Denuncia']['categoria']][] = '['.$pol['Denuncia']['horizontal'].','.$pol['Denuncia']['vertical'].']';
	        }	        
	        
	        if (empty($cordenada)){
	            unset($distritos[$i]);
	            continue;
	        }        
	        
	  
	        foreach ($a_delitos as $denuncia => $delitoCoordenadas ){	        
	            $delitos[] = array('delito'   => strtolower(str_replace(' ', '_', $denuncia)).'_20px.png',
	                               'type'     => 'Feature',
	                               'geometry' => array('type'        =>  'Polygon',
	                                   'coordinates' =>  array(array(implode($delitoCoordenadas, ','))))
	            );
	        }
	        
	        //pr($distrito);
	        //pr($delitos);
	    }
	 
	    $delitos = array('type' => 'FeatureCollection','features'=>$delitos);
	//pr($delitos);exit;
	    
	    $json = json_encode($delitos);
	    $json = str_replace('[["[', '[[[', $json);
	    $json = str_replace(']"]]', ']]]', $json);
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
	    
	    $provincia_id = $this->request->query['provincia_id'];
	    
	    if (isset($this->request->query['distrito_id'])){
	        $distrito_ids = $this->request->query['distrito_id'];
	    }else{
	        $options = array('fields'=>array('DISTINCT distrito_id'),'recursive' => -1);
	        $polygon_activo = $this->Distrito->DistPolygon->find('all',$options);
	        $distrito_ids = Hash::extract($polygon_activo, '{n}.DistPolygon.distrito_id');
	    }
	    
	    $options = array('fields'=>array('id','iddist','nombdist','nombprov','area_minam'),
	        'conditions' => array('provincia_id' => $provincia_id, 'id' => $distrito_ids),
	        'recursive' => -1);
	    $distritos = $this->Distrito->find('all',$options);
	    foreach ($distritos as $i => $row){
	        
	        $options = array('fields'=>array('id','horizontal','vertical','orden'),
	            'conditions'=>array('DistPolygon.distrito_id' => $row['Distrito']['id']),
	            'recursive' => -1,
	            'order' => array('id DESC')
	        );
	        
	        $polygon = $this->Distrito->DistPolygon->find('all',$options);
	        $cordenada=null;
	        foreach ($polygon as $pol){
	            $cordenada[] = '['.$pol['DistPolygon']['horizontal'].','.$pol['DistPolygon']['vertical'].']';
	        }
	        if (empty($cordenada)){
	            unset($distritos[$i]);
	            continue;
	        }
	        
	        $distritos[$i]['type'] = 'Feature';
	        $distritos[$i]['properties'] = $row['Distrito'];
	        unset($distritos[$i]['Distrito']);
	        $distritos[$i]['geometry'] = array('type' => 'Polygon',"coordinates"=>array(array(implode($cordenada, ','))));
	        //$distritos[$i]['geometry'] = array('type' => 'Polygon',"coordinates"=>array(array($cordenada)));
	    }
	    $distritos = array('type' => 'FeatureCollection','features'=>$distritos);
	    //pr($distritos);exit;
	    $json = json_encode($distritos);
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
	        $datajson = json_decode($this->request->data['Distrito']['datajson']);
	        //$data = Hash::extract($datajson->features, '{n}.properties');
	        //Hash::extract($datajson->features, '{n}.geometry');
	        unset($this->request->data['Distrito']);
	        
	        $transaccion = true;
	        foreach ($datajson->features as $i=> $dep){
	            $options = array('conditions' => array('nombprov' => $dep->properties->NOMBPROV),
	                              'recursive' => -1
	            );
	            $provincia = $this->Distrito->Provincia->find('first',$options);
	            
	            $fecha = explode('/', $dep->properties->FECHA);
	            if (isset($fecha[2])){
	                $fecha2 = array_reverse($fecha);
	                $fecha3 = implode('-', $fecha2);
	            }else{
	                $fecha3 = null;
	            }
	            
	            $this->request->data[$i]['Distrito']['iddist'] = $dep->properties->IDDIST;
	            $this->request->data[$i]['Distrito']['nom_cap']    = $dep->properties->NOM_CAP;
	            $this->request->data[$i]['Distrito']['nombdist']      = $dep->properties->NOMBDIST;
	            $this->request->data[$i]['Distrito']['nombprov']   = $dep->properties->NOMBPROV;
	            
	            $this->request->data[$i]['Distrito']['provincia_id'] = $provincia['Provincia']['id'];
	            $this->request->data[$i]['Distrito']['nombdep']    = $dep->properties->NOMBDEP;
	            $this->request->data[$i]['Distrito']['dcto']      = $dep->properties->DCTO;
	            $this->request->data[$i]['Distrito']['ley']   = $dep->properties->LEY;
	            
	            $this->request->data[$i]['Distrito']['fecha']      = $fecha3;
	            $this->request->data[$i]['Distrito']['area_minam']   = $dep->properties->AREA_MINAM;
	            
	            $this->Distrito->create();
	            if(!$this->Distrito->save($this->request->data[$i]['Distrito'])){
	                $transaccion = false;
	                break;
	            }
	            $distrito_id = $this->Distrito->getLastInsertId();
	            	            
	            if (!isset($dep->geometry->type)){
	                continue;
	            }
	            
	            if (($dep->geometry->type == 'MultiPolygon')){
	                unset($dep->geometry->coordinates[0]);
	                unset($dep->geometry->coordinates[1][1]);
	                $DistPolygons = Hash::extract($dep->geometry->coordinates, '{n}.{n}');
	            }else{
	                $DistPolygons = Hash::extract($dep->geometry->coordinates, '{n}');
	            }
	            
	            foreach ($DistPolygons[0] as $j=> $pol){
	                $this->request->data[$i]['Distrito']['DistPolygon'][$j]['distrito_id'] = $distrito_id;
	                $this->request->data[$i]['Distrito']['DistPolygon'][$j]['horizontal'] = $pol[0];
	                $this->request->data[$i]['Distrito']['DistPolygon'][$j]['vertical'] = $pol[1];
	                $this->Distrito->DistPolygon->create();
	                if (!$this->Distrito->DistPolygon->save($this->request->data[$i]['Distrito']['DistPolygon'][$j])) {
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
	            $this->Flash->success(__('El/la Distrito se ha guardado.'));
	            return $this->redirect(array('action' => 'index'));
	        }else{
	            $this->Flash->error(__('No se pudo guardar el/la Distrito. Por favor, inténtelo de nuevo.'));
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
		if (!$this->Distrito->exists($id)) {
			throw new NotFoundException(__('Invalido(a) distrito'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Distrito->save($this->request->data)) {
				$this->Flash->success(__('El/la distrito se ha guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('No se pudo guardar el/la distrito. Por favor, int�ntelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Distrito.' . $this->Distrito->primaryKey => $id));
			$this->request->data = $this->Distrito->find('first', $options);
		}
		$provincias = $this->Distrito->Provincium->find('list');
		$this->set(compact('provincias'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Distrito->id = $id;
		if (!$this->Distrito->exists()) {
			throw new NotFoundException(__('Invalid distrito'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Distrito->delete()) {
			$this->Flash->success(__('El/la distrito ha sido borrado.'));
		} else {
			$this->Flash->error(__('El/la distrito no ha sido borrado. Por favor int�ntelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
