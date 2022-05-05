<?php
App::uses('AppController', 'Controller');
/**
 * OrigenPenitenciarios Controller
 *
 * @property OrigenPenitenciario $OrigenPenitenciario
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class OrigenPenitenciariosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->OrigenPenitenciario->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->OrigenPenitenciario->displayField)?$this->OrigenPenitenciario->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['OrigenPenitenciario'][$campo] = $nombre ;
			$conditions = array('conditions' => array('OrigenPenitenciario.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('origenPenitenciarios', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->OrigenPenitenciario->exists($id)) {
			throw new NotFoundException(__('Invalid origen penitenciario'));
		}
		$options = array('conditions' => array('OrigenPenitenciario.' . $this->OrigenPenitenciario->primaryKey => $id));
		$this->set('origenPenitenciario', $this->OrigenPenitenciario->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->OrigenPenitenciario->create();
			if ($this->OrigenPenitenciario->save($this->request->data)) {
				$this->Flash->success(__('The origen penitenciario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The origen penitenciario could not be saved. Please, try again.'));
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
		if (!$this->OrigenPenitenciario->exists($id)) {
			throw new NotFoundException(__('Invalid origen penitenciario'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->OrigenPenitenciario->save($this->request->data)) {
				$this->Flash->success(__('The origen penitenciario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The origen penitenciario could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('OrigenPenitenciario.' . $this->OrigenPenitenciario->primaryKey => $id));
			$this->request->data = $this->OrigenPenitenciario->find('first', $options);
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
		$this->OrigenPenitenciario->id = $id;
		if (!$this->OrigenPenitenciario->exists()) {
			throw new NotFoundException(__('Invalid origen penitenciario'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->OrigenPenitenciario->delete()) {
			$this->Flash->success(__('The origen penitenciario has been deleted.'));
		} else {
			$this->Flash->error(__('The origen penitenciario could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
