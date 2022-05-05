<?php
App::uses('AppController', 'Controller');
/**
 * TipoDocumentos Controller
 *
 * @property TipoDocumento $TipoDocumento
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class TipoDocumentosController extends AppController {

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
		$this->TipoDocumento->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->TipoDocumento->displayField)?$this->TipoDocumento->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['TipoDocumento'][$campo] = $nombre ;
			$conditions = array('conditions' => array('TipoDocumento.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('tipoDocumentos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TipoDocumento->exists($id)) {
			throw new NotFoundException(__('Invalid tipo documento'));
		}
		$options = array('conditions' => array('TipoDocumento.' . $this->TipoDocumento->primaryKey => $id));
		$this->set('tipoDocumento', $this->TipoDocumento->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TipoDocumento->create();
			if ($this->TipoDocumento->save($this->request->data)) {
				$this->Flash->success(__('The tipo documento has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The tipo documento could not be saved. Please, try again.'));
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
		if (!$this->TipoDocumento->exists($id)) {
			throw new NotFoundException(__('Invalid tipo documento'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TipoDocumento->save($this->request->data)) {
				$this->Flash->success(__('The tipo documento has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The tipo documento could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TipoDocumento.' . $this->TipoDocumento->primaryKey => $id));
			$this->request->data = $this->TipoDocumento->find('first', $options);
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
		$this->TipoDocumento->id = $id;
		if (!$this->TipoDocumento->exists()) {
			throw new NotFoundException(__('Invalid tipo documento'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->TipoDocumento->delete()) {
			$this->Flash->success(__('The tipo documento has been deleted.'));
		} else {
			$this->Flash->error(__('The tipo documento could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
