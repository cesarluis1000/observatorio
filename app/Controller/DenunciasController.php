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

	
	public function denunciasgeojson(){
	    $this->layout = false;
	    $this->autoRender = false;
	    
	    //$this->response->type('json');
	    $this->loadModel('Distrito');
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
	        $options           = array('fields'     => array('id'),
	            'conditions'   =>  array('departamento_id' => $departamento_id),
	            'recursive'  => -1);
	        $provincias_act    = $this->Distrito->Provincia->find('all',$options);
	        $provincia_ids     = Hash::extract($provincias_act, '{n}.Provincia.id');
	    }
	    
	    //Obtenemos el distrito o distritos si es por PROVINCIA
	    if (isset($this->request->query['distrito_id']) && !empty($this->request->query['distrito_id'])){
	        $distrito_ids      = $this->request->query['distrito_id'];
	        /*$distrito_ids      = array(860,880,872,867,933,902,947,911);
	        $distrito_ids      = array(889,824,844,852,830,846,848,885,859);
	        $distrito_ids      = array(842,829,850,832,802,821,819,825,794,815,814,811,805,816,812,791);
	        $distrito_ids      = array(797,784,796,827,787,785,779,750,740,739);*/
	    }else{
	        $options           = array('fields'     =>  array('id'),
	            'conditions' =>  array('provincia_id' => $provincia_ids),
	            'recursive'  =>  -1);
	        $polygon_activo    = $this->Distrito->find('all',$options);
	        $distrito_ids      = Hash::extract($polygon_activo, '{n}.Distrito.id');
	    }
	    
	    $options = array(  'fields'       =>  array('id'),
	        'conditions'   =>  array('provincia_id' => $provincia_ids, 'Distrito.id' => $distrito_ids),
	        'recursive'    =>  -1);
	    //pr($options); exit;
	    //Quitamos la relaccion del perimetro del distritos
	    $this->Distrito->unbindModel(array('hasMany'=>array('DistPolygon')));
	    
	    $distritos = $this->Distrito->find('all',$options);
	    //pr($distritos);exit;
	    $delitos       = null;
	    $conditions    = array();
	    
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
	    
	    $conditions = array_merge($conditions,array('Denuncia.distrito_id'  => $distrito_ids,
	                                               'Denuncia.estado_google' => 'OK',
                                        	        //'ST_Distance(Distrito.geom, Point(ST_X(Denuncia.geom), ST_Y(Denuncia.geom)))*110 <= 1',
                                        	        'Denuncia.geom IS NOT NULL'
	                               ));
	    //pr($conditions); //exit;
	    
	    $options = array('fields'=>array('id','TipoDenuncia.nombre', 'geojson'),
            	        'conditions'=> $conditions,
            	        //'recursive' => -1,
            	        'order' => array('categoria DESC'),
            	    );
	    
	    $denuncias = $this->Distrito->Denuncia->find('all',$options);
	    
	    $geojson = null;
	    foreach ($denuncias as $i  => $row){
	        $geojson[$i]['type']       = 'Feature';
	        $geojson[$i]['properties'] = array('denuncia' => $row['TipoDenuncia']['nombre'],
                                               'icon' => strtolower(str_replace(' ', '_', $row['TipoDenuncia']['nombre'])).'_20px.png'
	                                           );
	        $geojson[$i]['geometry']   = $row['Denuncia']['geojson'];
	    }
	    
	    $geojson = array('type' => 'FeatureCollection','features'=>$geojson);
	    //pr($geojson); //exit;
	    
	    $geojson = json_encode($geojson);
	    $geojson = str_replace(':"{', ':{', $geojson);
	    $geojson = str_replace('}"}', '}}', $geojson);
	    $geojson = str_replace('\\', '', $geojson);
	    //pr($geojson);
	    $this->response->body($geojson);
	}
	
	public function coordenadasjson(){	    
	    set_time_limit(108000);
	    ini_set('memory_limit','1024M');
	    
	    $options = array(//'fields'=>array('id','nro_denuncia','ubicacion','horizontal','vertical'),,'Denuncia.distrito_id'=>'811'
	        'conditions' => array(//'Denuncia.nro_denuncia'=>'10354410',
	            //'Denuncia.id'=>'245747',
	            'estado_google IS NULL',
	            //'tipo_denuncia_id !=' => '9'
	        ),
	        //'recursive' => -1,
	        //'order' => array('nombdist')
	    );
	    
	    $denuncias = $this->Denuncia->find('all',$options);
	    //pr($denuncias);exit;
	    
	    $transaccion = true;
	    foreach ($denuncias as $denuncia){
	        //pr($denuncia['Denuncia']);exit;
	        $direccion = $denuncia['Denuncia']['ubicacion'].' '.$denuncia['Distrito']['nombdist'].' '.$denuncia['Distrito']['nombprov'];
	        //pr($direccion);exit;
	        
	        $direccion = str_replace(' ', '+', $direccion);        
            //&components=country:PE
	        //$url = "https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=YOUR_API_KEY";
	        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccion&components=country:PE&key=AIzaSyC7e2Iboim4HC-CfX2PmJR6BkSI8aSKb1U"; // Cesar
	        //$url = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccion&components=country:PE&key=AIzaSyCuTvwg-QiTAvdnff1U8VT74q_iUAsyL2g"; // Emma
	        //$url = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccion&components=country:PE&key=AIzaSyAHt7TwBL4nlTAjoN9-jQdqyaN-fj3u41g"; // Luis	        
	        //$url = "https://maps.googleapis.com/maps/api/geocode/json?address=$direccion&components=country:PE&key=AIzaSyC6Hv9oFodbGJJ19gCy2XTj0mKCow7g-8Y"; // Kilder
	        //pr($url); 
	        //exit;
	        
	        $geo = file_get_contents($url);
	        
	        $geo = json_decode($geo, true); // Convert the JSON to an array
	        //pr($geo); exit;
	        if (isset($geo['status']) && ($geo['status'] == 'OK')) {	            
	            $denuncia['Denuncia']['vertical']          = $latitud  = number_format($geo['results'][0]['geometry']['location']['lat'],6,'.',''); // Latitude
	            $denuncia['Denuncia']['horizontal']        = $longitud = number_format($geo['results'][0]['geometry']['location']['lng'],6,'.',''); // Longitude
	            $denuncia['Denuncia']['estado_google']     = $geo['status'];
	            //$denuncia['Denuncia']['geom']              = "ST_GeomFromText('Point($latitud $longitud)')";
	            $denuncia['Denuncia']['geom']              = null;
	            $denuncia['Denuncia']['ubicacion_google']  = $geo['results'][0]['formatted_address'];
	        }else{
	            $denuncia['Denuncia']['estado_google']    = 'KO';	            
	        }
	        
	        if(!$this->Denuncia->save($denuncia['Denuncia'])){
	            //pr($this->Denuncia->validationErrors); exit;
	            $transaccion = false;
	            break;
	        }
	        //pr($denuncia['Denuncia']); exit; 
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
