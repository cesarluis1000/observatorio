<?php
App::uses('AppController', 'Controller');
/**
 * ZonaPolygons Controller
 *
 * @property ZonaPolygon $ZonaPolygon
 * @property PaginatorComponent $Paginator
 */
class ZonaPolygonsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function panamericanosgeojson(){
	    
	    $this->autoRender = false;
	    $this->response->type('json');
	    
	    $options = array('fields'  =>  array('id','nombre'),
            	        'conditions'   =>  array('Institucion.tipo_institucion_id' => 4), //Juegos Panamericanos
            	        'recursive'    =>  -1
                	    );        
	    
	    $zonas     = $this->ZonaPolygon->Institucion->find('all', $options);
	    
	    foreach ($zonas as $i => $row){
	        
	        $options = array('fields'      =>  array('id','horizontal','vertical','orden'),
            	            'conditions'   =>  array('ZonaPolygon.institucion_id' => $row['Institucion']['id']),
            	            'recursive'    =>  -1,
            	            'order'        =>  array('id DESC')
            	        );
	        
	        $polygon   =   $this->ZonaPolygon->find('all',$options);
	        $cordenada =   null;
	        
	        foreach ($polygon as $pol){
	            $cordenada[] = '['.$pol['ZonaPolygon']['horizontal'].','.$pol['ZonaPolygon']['vertical'].']';
	        }
	        if (empty($cordenada)){
	            unset($zonas[$i]);
	            continue;
	        }
	        
	        $zonas[$i]['type'] = 'Feature';
	        $zonas[$i]['properties'] = $row['Institucion'];
	        unset($zonas[$i]['Institucion']);
	        $zonas[$i]['geometry'] = array('type' => 'Polygon',"coordinates"=>array(array(implode($cordenada, ','))));
	    }
	    
	    
	    $zonas     = array('type' => 'FeatureCollection','features'=>$zonas);
	    //pr($zonas);exit;
	    $json = json_encode($zonas);
	    $json = str_replace('[["[', '[[[', $json);
	    $json = str_replace(']"]]', ']]]', $json);
	    $this->response->body($json);
	    
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ZonaPolygon->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->ZonaPolygon->displayField)?$this->ZonaPolygon->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['ZonaPolygon'][$campo] = $nombre ;
			$conditions = array('conditions' => array('ZonaPolygon.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('zonaPolygons', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ZonaPolygon->exists($id)) {
			throw new NotFoundException(__('Invalid zona polygon'));
		}
		$options = array('conditions' => array('ZonaPolygon.' . $this->ZonaPolygon->primaryKey => $id));
		$this->set('zonaPolygon', $this->ZonaPolygon->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ZonaPolygon->create();
			if ($this->ZonaPolygon->save($this->request->data)) {
				$this->Flash->success(__('The zona polygon has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The zona polygon could not be saved. Please, try again.'));
			}
		}
		$instituciones = $this->ZonaPolygon->Institucion->find('list');
		$this->set(compact('instituciones'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ZonaPolygon->exists($id)) {
			throw new NotFoundException(__('Invalid zona polygon'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ZonaPolygon->save($this->request->data)) {
				$this->Flash->success(__('The zona polygon has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The zona polygon could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ZonaPolygon.' . $this->ZonaPolygon->primaryKey => $id));
			$this->request->data = $this->ZonaPolygon->find('first', $options);
		}
		$instituciones = $this->ZonaPolygon->Institucion->find('list');
		$this->set(compact('instituciones'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ZonaPolygon->id = $id;
		if (!$this->ZonaPolygon->exists()) {
			throw new NotFoundException(__('Invalid zona polygon'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ZonaPolygon->delete()) {
			$this->Flash->success(__('The zona polygon has been deleted.'));
		} else {
			$this->Flash->error(__('The zona polygon could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
