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
	    
	    //Obtenemos la provincia o provincias de los DEPARTAMENTO
	    if (isset($this->request->query['provincia_id'])){
	        $provincia_ids     = $this->request->query['provincia_id'];
	    }else{
	        $options           = array('fields'        => array('DISTINCT id'),
                        	            'conditions'   =>  array('departamento_id' => $departamento_id),
                        	            'recursive'    => -1);
	        $provincias_act    = $this->Distrito->Provincia->find('all',$options);
	        $provincia_ids     = Hash::extract($provincias_act, '{n}.Provincia.id');
	    }
	    
	    //Obtenemos el distrito o distritos si es por PROVINCIA
	    if (isset($this->request->query['distrito_id']) && !empty($this->request->query['distrito_id'])){
	        $distrito_ids      = $this->request->query['distrito_id'];
	    }else{
	        $options           = array('fields'        =>  array('DISTINCT id'),
                        	            'conditions'   =>  array('provincia_id' => $provincia_ids),
                        	            'recursive'    =>  -1);
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
	    //pr($distritos);exit;
	    $delitos = null;
	    
	    $conditions   = array();
	    if (isset($this->request->query['reporte']) && !empty($this->request->query['reporte'])){
	        $reporte      = $this->request->query['reporte'];
	        switch ($reporte){
	            case 'panamericano': $conditions   = array('Institucion.tipo_institucion_id' =>  array('1','2')); break;
	            case 'criminologico': $conditions  = array('Institucion.tipo_institucion_id' =>  array('1','2','7')); break;
	            case 'presos'      : $conditions   = array('Institucion.tipo_institucion_id' =>  array('1','2','5','6'));break;
	        }	        
	    }
	    
	    foreach ($distritos as $i => $distrito){
	        
	        $conditions2    = array('Institucion.distrito_id' => $distrito['Distrito']['id'],
	                               'Institucion.longitud !=' => '0.00000000',
	                               //'Institucion.tipo_denuncia_id' =>  array('1','5')
	                               );
	        $conditions    = array_merge($conditions,$conditions2);
	        
	        $options       = array('conditions'=> $conditions);
	        //pr($options); //exit();
	        $polygon       = $this->Institucion->find('all',$options);
	        //pr($polygon); exit();
	        $a_institucion = null;
	        
	        foreach ($polygon as $pol){
	            if (in_array($pol['Institucion']['tipo_denuncia_id'], array('1','5')) || empty($pol['Institucion']['tipo_denuncia_id'])) {
	                $tipoInstitucion           = $pol['TipoInstitucion']['institucion'];
	                $institucionCoordenadas    = '['.$pol['Institucion']['longitud'].','.$pol['Institucion']['latitud'].']';
	                $delitos[]                 = array( 'institucion'  => $tipoInstitucion.'60px.png',
	                    'type'                 => 'Feature',
	                    'tipoDenuncia'         => $pol['TipoDenuncia']['nombre'],
	                    'tipoInstitucion'      => $pol['TipoInstitucion']['institucion'],
	                    'institucionId'        => $pol['Institucion']['id'],
	                    'institucionNombre'    => empty($pol['Institucion']['tipo_denuncia_id'])?$pol['Institucion']['nombre']:$pol['TipoDenuncia']['nombre'],
	                    'institucionUbicacion' => $pol['Institucion']['ubicacion'],
	                    'geometry'             => array('type'         => 'Polygon',
	                        'coordinates'  => array(
	                            array($institucionCoordenadas)
	                        )
	                    )
	                );
	            }
	        }
	       
	    }
	    //pr($delitos);exit;
	    $delitos = array('type' => 'FeatureCollection','features'=>$delitos);
	    
	    
	    $json = json_encode($delitos);
	    $json = str_replace('[["[', '[[[', $json);
	    $json = str_replace(']"]]', ']]]', $json);
	    $this->response->body($json);;
	}

	
	public function delitosgeojson() {
	    //$this->layout = false;
	    $this->autoRender = false;
	    $this->response->type('json');	    	    
	    
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
	    if (isset($this->request->query['distrito_id']) && !empty($this->request->query['distrito_id'])){
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
	        
	        $options = array('fields'=>array('id','horizontal','vertical','categoria', 'ST_X(geom) as lat', 'ST_Y(geom) as lng'),
	            'conditions'=> $conditions,
	            'recursive' => -1,
	            'order' => array('categoria DESC'),
	        );
	        
	        $polygon = $this->Distrito->Denuncia->find('all',$options);
	        //pr($polygon); exit;
	        $cordenada=null;
	        $a_delitos=null;
	        foreach ($polygon as $pol){
	            $cordenada[] = '['.$pol['Denuncia']['horizontal'].','.$pol['Denuncia']['vertical'].']';
	            $a_delitos[$pol['Denuncia']['categoria']][] = '['.$pol['0']['lng'].','.$pol['0']['lat'].']';
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
	    
	    if (isset($this->request->query['distrito_id']) && !empty($this->request->query['distrito_id'])){
	        $distrito_ids = $this->request->query['distrito_id'];
	    }else{
	        /*
	        $options           = array('fields'=>array('DISTINCT distrito_id'),'recursive' => -1);
	        $polygon_activo    = $this->Distrito->DistPolygon->find('all',$options);
	        $distrito_ids      = Hash::extract($polygon_activo, '{n}.DistPolygon.distrito_id');
	        */
	        $options       = array('fields'=>array('id'),
	                               'conditions'   =>  array('estado'=>'A', 'provincia_id' => $provincia_id),
                    	            'recursive'    =>  -1);
	        $distritos_act = $this->Distrito->find('all',$options);
	        $distrito_ids  = Hash::extract($distritos_act, '{n}.Distrito.id');
	        
	    }
	    
	    $options = array('fields'      =>  array('id','iddist','nombdist','nombprov','area_minam'),
            	        'conditions'   =>  array('provincia_id' => $provincia_id, 'id' => $distrito_ids),
            	        'recursive'    =>  -1);
	    
	    $distritos = $this->Distrito->find('all',$options);
	    
	    foreach ($distritos as $i => $row){
	        
	        $options = array('fields'      =>  array('id','horizontal','vertical','orden'),
            	            'conditions'   =>  array('DistPolygon.distrito_id' => $row['Distrito']['id']),
            	            'recursive'    =>  -1,
            	            'order'        =>  array('id DESC')
            	        );
	        
	        $polygon   =   $this->Distrito->DistPolygon->find('all',$options);	        
	        $cordenada =   null;
	        
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

	    }
	    $distritos = array('type' => 'FeatureCollection','features'=>$distritos);
	    
	    //pr($distritos);exit;
	    $json = json_encode($distritos);
	    //pr($json);
	    $json = str_replace('[["[', '[[[', $json);
	    $json = str_replace(']"]]', ']]]', $json);
	    //pr($json);exit;
	    $this->response->body($json);
	    
	}
	
	public function geometry(){
	    $this->layout = false;
	    $this->autoRender = false;
	    //$this->response->type('json');	   
	    
	    $provincia_id = $this->request->query['provincia_id'];
	    if (isset($this->request->query['distrito_id']) && !empty($this->request->query['distrito_id'])){
	        $distrito_ids = $this->request->query['distrito_id'];
	    }else{
	        $options       = array('fields'=>array('id'),
                    	            'conditions'   =>  array('estado'=>'A', 'provincia_id' => $provincia_id),
                    	            'recursive'    =>  -1);
	        $distritos_act = $this->Distrito->find('all',$options);
	        $distrito_ids  = Hash::extract($distritos_act, '{n}.Distrito.id');
	        
	    }
	    $options = array('fields'      =>  array('id','iddist','nombdist','nombprov','area_minam'),
            	         'conditions'   =>  array('provincia_id' => $provincia_id, 'id' => $distrito_ids),
            	         'recursive'    =>  -1);
	    
	    $distritos = $this->Distrito->find('all',$options);
	    //pr($distritos);
	    $poligonos = null;
	    foreach ($distritos as $i => $row){
	        
	        $options = array('fields'      =>  array('id','vertical','horizontal','orden'),
            	            'conditions'   =>  array('DistPolygon.distrito_id' => $row['Distrito']['id']),
            	            'recursive'    =>  -1,
            	            'order'        =>  array('id DESC')
	        );
	        
	        $polygon   =   $this->Distrito->DistPolygon->find('all',$options);	        
	        $cordenada =   null;
	        
	        foreach ($polygon as $pol){
	            $cordenada[] = $pol['DistPolygon']['vertical'].' '.$pol['DistPolygon']['horizontal'];
	        }
	        
	        
	        
	        if (empty($cordenada)){
	            unset($distritos[$i]);
	            continue;
	        }
	        unset($distritos[$i]['Distrito']);
	        $poligonos .= "UPDATE distritos SET geom = ST_GeomFromText('POLYGON((".implode($cordenada, ',')."))') WHERE id = ".$row['Distrito']['id'].';<br>';
	        
	    }
	    pr($poligonos);
	    $this->response->body();
	    
	}

	public function delitoschartjs(){
	    $this->layout = false;
	    $this->autoRender = false;
	    $this->loadModel('Denuncia');
	    $this->loadModel('TipoDenuncia');
	    
	    $provincia_id = $this->request->query['provincia_id'];
	    
	    if (isset($this->request->query['distrito_id']) && !empty($this->request->query['distrito_id'])){
	        $distrito_ids = $this->request->query['distrito_id'];
	    }else{
	        /*
	         $options           = array('fields'=>array('DISTINCT distrito_id'),'recursive' => -1);
	         $polygon_activo    = $this->Distrito->DistPolygon->find('all',$options);
	         $distrito_ids      = Hash::extract($polygon_activo, '{n}.DistPolygon.distrito_id');
	         */
	        $options       = array('fields'=>array('id'),
	            'conditions'   =>  array('estado'=>'A', 'provincia_id' => $provincia_id),
	            'recursive'    =>  -1);
	        $distritos_act = $this->Distrito->find('all',$options);
	        $distrito_ids  = Hash::extract($distritos_act, '{n}.Distrito.id');
	        
	    }
	    
	    //No se esta conciderando OTROS y vIOLENCIA FAMILIAR
	    $denuncias = $this->TipoDenuncia->find('all', array('fields'       => array('TipoDenuncia.nombre'),
                                                	        'conditions'   => array('TipoDenuncia.id !=' => array(8,9)),
	                                                         'recursive'   => -1
                                                	    ));
	    
	    $datasets = array();
	    
	    $backgroundColor   = array('RGBA(215, 222, 7, 0.2)','RGBA(79, 207, 219, 0.2)','RGBA(255, 0, 0, 0.2)','RGBA(216, 123, 219, 0.2)','RGBA(0, 0, 255, 0.2)','RGBA(0, 255, 0, 0.2)','RGBA(100, 50, 0, 0.2)','RGBA(50, 0, 50, 0.2)');
	    $borderColor       = array('RGBA(215, 222, 7, 0.8)','RGBA(79, 207, 219, 0.8)','RGBA(255, 0, 0, 0.8)','RGBA(216, 123, 219, 0.8)','RGBA(0, 0, 255, 0.8)','RGBA(0, 255, 0, 0.8)','RGBA(100, 50, 0, 0.8)','RGBA(50, 0, 50, 0.8)');
	    
	    //pr($denuncias);
	    //pr($backgroundColor);
	    foreach ($denuncias as $i => $row){	        
	        
	        $conditions    = array('Denuncia.categoria'    => $row['TipoDenuncia']['nombre'],
	                               'Denuncia.fecha_hecho BETWEEN ? AND ?'  => array('2019-01-01','2019-09-31'),
	                               'Denuncia.distrito_id'  => $distrito_ids,
	                               'Denuncia.estado_google'  => 'OK',
	                               //'MONTH(fecha_hecho)' => 1
	                               );
	        $options       = array(
                	            'conditions' => $conditions,
	                            'fields'=>array('Denuncia.categoria','YEAR(fecha_hecho) as anio', 'MONTH(fecha_hecho) as mes', 'COUNT(id) as denuncia_count'),
                	            //'joins' => array('LEFT JOIN `entities` AS Entity ON `Entity`.`category_id` = `Category`.`id`'),
	                            'group' => array('YEAR(fecha_hecho)', 'MONTH(fecha_hecho)'),'recursive'=>-1
                	            //'contain' => array('Domain' => array('fields' => array('title')))
                	        );
	        
	        $denuncia_cant = $this->Denuncia->find('all', $options);
	        	        
	        $data = Hash::extract($denuncia_cant, '{n}.0.denuncia_count');
	        $data = Hash::combine($denuncia_cant, '{n}.0.mes', '{n}.0.denuncia_count');
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
	        
	        $datasets[$i]  = array( 'label'             =>  $row['TipoDenuncia']['nombre'],
                    	            'fill'              =>  false,
	                                'backgroundColor'   =>  $backgroundColor[$i],
	                                'borderColor'       =>  $borderColor[$i],
	                                'data'              =>  $data//array(881,734,786,670,761,780,669,885,415),
                    	        );
	    }
	    
	    //pr($datasets);
	    //exit;
	    /*
	    $delitos = array(  'type'      => 'line',
	                       'data'      =>  array(  'labels' => array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Augusto', 'Septiembre'),
	                                               'datasets'  =>  array(  array(  'label'             =>  'HURTO',
	                                                                               'fill'              =>  false,
	                                                                               'backgroundColor'   =>  'RGBA(255, 0, 0, 0.2)',
	                                                                               'borderColor'       =>  'RGBA(255, 0, 0, 0.8)',
	                                                                               'data'              =>  array(881,734,786,670,761,780,669,885,415),
	                                                                           ),
                    	                                                   array(  'label'             =>  'ROBO',
                        	                                                       'fill'              =>  false,
                        	                                                       'backgroundColor'   =>  'RGBA(0, 255, 0, 0.2)',
                        	                                                       'borderColor'       =>  'RGBA(0, 255, 0, 0.8)',
                        	                                                       'data'              =>  array(500,800,600,761,780,669,885,415,900),
                    	                                                       )
	                                                                   )
                                                ),
            	           'options'   =>  array(  'responsive'    => true,
            	                                   'title'         => array(   'display'   =>  true,
            	                                                               'text'      =>  'Distrito Lima'),
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
        */	    
	    //pr($delitos);
	    $delitos2 = array(  'type'      => 'line',
	        'data'      =>  array(  'labels' => array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Augusto', 'Septiembre'),
	            'datasets'  =>  $datasets
	        ),
	        'options'   =>  array(  'responsive'    => true,
	            'title'         => array(   'display'   =>  true,
	                'text'      =>  'Distrito Lima'),
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
	    //pr($delitos);exit;
	    //$json = json_encode($delitos);
	    $json = json_encode($delitos2);
	    $this->response->body($json);
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
