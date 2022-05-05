<?php
App::uses('AppController', 'Controller');
/**
 * DelitoEspecificos Controller
 *
 * @property DelitoEspecifico $DelitoEspecifico
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class DelitoEspecificosController extends AppController {

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
		$this->DelitoEspecifico->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->DelitoEspecifico->displayField)?$this->DelitoEspecifico->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['DelitoEspecifico'][$campo] = $nombre ;
			$conditions = array('conditions' => array('DelitoEspecifico.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('delitoEspecificos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DelitoEspecifico->exists($id)) {
			throw new NotFoundException(__('Invalid delito especifico'));
		}
		$options = array('conditions' => array('DelitoEspecifico.' . $this->DelitoEspecifico->primaryKey => $id));
		$this->set('delitoEspecifico', $this->DelitoEspecifico->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DelitoEspecifico->create();
			if ($this->DelitoEspecifico->save($this->request->data)) {
				$this->Flash->success(__('The delito especifico has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The delito especifico could not be saved. Please, try again.'));
			}
		}
		$delitoGenericos = $this->DelitoEspecifico->DelitoGenerico->find('list');
		$this->set(compact('delitoGenericos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->DelitoEspecifico->exists($id)) {
			throw new NotFoundException(__('Invalid delito especifico'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->DelitoEspecifico->save($this->request->data)) {
				$this->Flash->success(__('The delito especifico has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The delito especifico could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DelitoEspecifico.' . $this->DelitoEspecifico->primaryKey => $id));
			$this->request->data = $this->DelitoEspecifico->find('first', $options);
		}
		$delitoGenericos = $this->DelitoEspecifico->DelitoGenerico->find('list');
		$this->set(compact('delitoGenericos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->DelitoEspecifico->id = $id;
		if (!$this->DelitoEspecifico->exists()) {
			throw new NotFoundException(__('Invalid delito especifico'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->DelitoEspecifico->delete()) {
			$this->Flash->success(__('The delito especifico has been deleted.'));
		} else {
			$this->Flash->error(__('The delito especifico could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
