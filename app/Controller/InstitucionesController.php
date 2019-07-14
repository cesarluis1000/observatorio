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
}
