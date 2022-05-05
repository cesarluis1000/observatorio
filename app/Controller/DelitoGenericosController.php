<?php
App::uses('AppController', 'Controller');
/**
 * DelitoGenericos Controller
 *
 * @property DelitoGenerico $DelitoGenerico
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class DelitoGenericosController extends AppController {

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
		$this->DelitoGenerico->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->DelitoGenerico->displayField)?$this->DelitoGenerico->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['DelitoGenerico'][$campo] = $nombre ;
			$conditions = array('conditions' => array('DelitoGenerico.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('delitoGenericos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DelitoGenerico->exists($id)) {
			throw new NotFoundException(__('Invalid delito generico'));
		}
		$options = array('conditions' => array('DelitoGenerico.' . $this->DelitoGenerico->primaryKey => $id));
		$this->set('delitoGenerico', $this->DelitoGenerico->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DelitoGenerico->create();
			if ($this->DelitoGenerico->save($this->request->data)) {
				$this->Flash->success(__('The delito generico has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The delito generico could not be saved. Please, try again.'));
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
		if (!$this->DelitoGenerico->exists($id)) {
			throw new NotFoundException(__('Invalid delito generico'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DelitoGenerico->save($this->request->data)) {
				$this->Flash->success(__('The delito generico has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The delito generico could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DelitoGenerico.' . $this->DelitoGenerico->primaryKey => $id));
			$this->request->data = $this->DelitoGenerico->find('first', $options);
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
		$this->DelitoGenerico->id = $id;
		if (!$this->DelitoGenerico->exists()) {
			throw new NotFoundException(__('Invalid delito generico'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->DelitoGenerico->delete()) {
			$this->Flash->success(__('The delito generico has been deleted.'));
		} else {
			$this->Flash->error(__('The delito generico could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
