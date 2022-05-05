<?php
App::uses('AppController', 'Controller');
/**
 * EstabPenitenciarios Controller
 *
 * @property EstabPenitenciario $EstabPenitenciario
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class EstabPenitenciariosController extends AppController {

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
		$this->EstabPenitenciario->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->EstabPenitenciario->displayField)?$this->EstabPenitenciario->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['EstabPenitenciario'][$campo] = $nombre ;
			$conditions = array('conditions' => array('EstabPenitenciario.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('estabPenitenciarios', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->EstabPenitenciario->exists($id)) {
			throw new NotFoundException(__('Invalid estab penitenciario'));
		}
		$options = array('conditions' => array('EstabPenitenciario.' . $this->EstabPenitenciario->primaryKey => $id));
		$this->set('estabPenitenciario', $this->EstabPenitenciario->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->EstabPenitenciario->create();
			if ($this->EstabPenitenciario->save($this->request->data)) {
				$this->Flash->success(__('The estab penitenciario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The estab penitenciario could not be saved. Please, try again.'));
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
		if (!$this->EstabPenitenciario->exists($id)) {
			throw new NotFoundException(__('Invalid estab penitenciario'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->EstabPenitenciario->save($this->request->data)) {
				$this->Flash->success(__('The estab penitenciario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The estab penitenciario could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('EstabPenitenciario.' . $this->EstabPenitenciario->primaryKey => $id));
			$this->request->data = $this->EstabPenitenciario->find('first', $options);
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
		$this->EstabPenitenciario->id = $id;
		if (!$this->EstabPenitenciario->exists()) {
			throw new NotFoundException(__('Invalid estab penitenciario'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->EstabPenitenciario->delete()) {
			$this->Flash->success(__('The estab penitenciario has been deleted.'));
		} else {
			$this->Flash->error(__('The estab penitenciario could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
