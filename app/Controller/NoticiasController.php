<?php
App::uses('AppController', 'Controller');
/**
 * Noticias Controller
 *
 * @property Noticia $Noticia
 * @property PaginatorComponent $Paginator
 */
class NoticiasController extends AppController {

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
		$this->Noticia->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->Noticia->displayField)?$this->Noticia->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['Noticia'][$campo] = $nombre ;
			$conditions = array('conditions' => array('Noticia.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('noticias', $this->Paginator->paginate());
	}

	public function index2() {
	  
	    $conditions = array();
	    $offset = 0;
	    if (isset($this->request->query['offset']) && !empty($this->request->query['offset'])){
	        $offset = $this->request->query['offset'];
	    }
	    
	    $limit = 10;
	    if (isset($this->request->query['limit']) && !empty($this->request->query['limit'])){
	        $limit = $this->request->query['limit'];
	    }
	    
	    $options = array('conditions'=> $conditions,
	        'order' => array('fecha DESC'),
	        'offset' => $offset,
	        'limit'=> $limit,
	        'recursive' => 1);
	    
	    $noticias  = $this->Noticia->find('all',$options);
	    //pr($this->Message->getLastQuery());
	    $optionsCount  = array('conditions'=> $conditions,
	        'order' => array('fecha DESC'),
	        'recursive' => 1);
	    
	    $count = $this->Noticia->find('count',$optionsCount);
	    
	    $offsetNext    = $offset + $limit;
	    $next          = ($offset + $limit >= $count) ? null : Router::url('/', true).'api/noticias.json?offset='.$offsetNext.'&limit='.$limit;
	    
	    $offsetPrev    = $offset - $limit;
	    $previous      = ($offsetPrev < 0) ? null : Router::url('/', true).'api/noticias.json?&offset='.$offsetPrev.'&limit='.$limit;
	    
	    $this->set(compact('count', 'next', 'previous', 'noticias'));
	    
	    $this->set(array(
	        '_serialize' => array('count', 'next', 'previous', 'noticias')
	    ));
	}
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Noticia->exists($id)) {
			throw new NotFoundException(__('Invalid noticia'));
		}
		$options = array('conditions' => array('Noticia.' . $this->Noticia->primaryKey => $id));
		$this->set('noticia', $this->Noticia->find('first', $options));
	}
	
	public function view2($id) {
	    $options = array('conditions' => array('Noticia.id' => $id),
	        'recursive' => 1);
	    $Noticia = $this->Noticia->find('first',$options);
	    
	    $Noticia = Set::extract($Noticia, 'Noticia');
	    $this->set(array(
	        'Noticia' => $Noticia,
	        '_serialize' => array('Noticia')
	    ));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {

	    if ($this->request->is('post')) {
	        
	        $datasource = $this->Noticia->getDataSource();
	        
	        try{
	            
	            $datasource->begin();
	            
	            $uploadData = $this->request->data['Noticia']['file'];
	            $this->request->data['Noticia']['imagen'] = null;
	            
	            $this->Noticia->create();
	            if (!$this->Noticia->save($this->request->data)) {
	                throw new Exception('The noticia could not be saved. Please, try again.');
	            }
	            
	            if (!empty($uploadData['name'])){
	                
	                if ( $uploadData['size'] > 2048000 || $uploadData['error'] !== 0) {
	                    throw new Exception('La imagen excede el tamaño de 2 mb, intente nuevamente.');
	                }
	                
	                if ( $uploadData['type'] != 'image/jpeg') {
	                    throw new Exception('La imagen  no es de tipo JPG, intente nuevamente.');
	                }
	                
	                $noticiaId = $this->Noticia->getInsertID();
	                $path      = $noticiaId.".jpeg";
	                $this->Noticia->id  = $noticiaId;
	                
	                if(!$this->Noticia->saveField('imagen', $path)){
	                    throw new Exception('Error de path');
	                }
	                
	                $this->request->data['Noticia']['id']      = $noticiaId;
	                $this->request->data['Noticia']['imagen']  = $path;
	                
	                //$uploadFolder = WWW_ROOT. 'img';
	                if( !file_exists($this->uploadFolder) ){
	                    mkdir($this->uploadFolder);
	                }
	                
	                $uploadPath =  $this->uploadFolder . DS . $path;
	                if (!move_uploaded_file($uploadData['tmp_name'], $uploadPath)) {
	                    throw new Exception('No se pudo guardar la imagen.');
	                }
	                
	            }
	            
	            $datasource->commit();
	    
	            
	            $this->Flash->success(__('La noticia fue guardado'));
	            return $this->redirect(array('action' => 'index'));
	            
	        }catch(Exception $e){
	            $datasource->rollback();
	            $this->Flash->error($e);
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
	    //pr($this->request->data); exit;
	    if (!$this->Noticia->exists($id)) {
	        throw new NotFoundException(__('Invalid noticia'));
	    }
	    if ($this->request->is(array('post', 'put'))) {
	        
	        $datasource = $this->Noticia->getDataSource();
	        
	        try{
	            
	            $datasource->begin();
	            if (!empty($this->request->data['Noticia']['file']['name'])){
	                
	                $uploadData = $this->data['Noticia']['file'];
	                if ( $uploadData['size'] > 2048000 || $uploadData['error'] !== 0) {
	                    throw new Exception('La imagen excede el tamaño de 2 mb, intente nuevamente.');
	                }
	                
	                if ( $uploadData['type'] != 'image/jpeg') {
	                    throw new Exception('La imagen no es de tipo JPG, intente nuevamente.');
	                }
	                
	                if( !file_exists($this->uploadFolder) ){
	                    mkdir($this->uploadFolder);
	                }
	                
	                $path      = $id.".jpeg";
	                $uploadPath =  $this->uploadFolder . DS . $path;
	                if (!move_uploaded_file($uploadData['tmp_name'], $uploadPath)) {
	                    throw new Exception('No se pudo guardar la imagen.');
	                }
	                
	                $this->Noticia->id  = $id;
	                if(!$this->Noticia->saveField('imagen', $path)){
	                    throw new Exception('Error de path');
	                }
	                
	            }
	            
	            if ($this->Noticia->save($this->request->data)) {
	                $datasource->commit();
	                
	                $this->Flash->success(__('The message has been saved.'));
	                return $this->redirect(array('action' => 'index'));
	            } else {
	                throw new Exception('The message could not be saved. Please, try again.');
	            }
	            
	        }catch(Exception $e){
	            $datasource->rollback();
	            $options = array('conditions' => array('Noticia.' . $this->Noticia->primaryKey => $id));
	            $this->request->data = $this->Noticia->find('first', $options);
	            $this->Flash->error($e);
	        }
	        
	    } else {
	        $options = array('conditions' => array('Noticia.' . $this->Noticia->primaryKey => $id));
	        $this->request->data = $this->Noticia->find('first', $options);
	    }
	    
	    $random1 = substr(number_format(time() * rand(),0,'',''),0,10);
	    $imagen  = $this->request->data['Noticia']['imagen'].'?n='.$random1;
	    $this->set(compact('imagen'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Noticia->id = $id;
		if (!$this->Noticia->exists()) {
			throw new NotFoundException(__('Invalid noticia'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Noticia->delete()) {
			$this->Flash->success(__('The noticia has been deleted.'));
		} else {
			$this->Flash->error(__('The noticia could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
