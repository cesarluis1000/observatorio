<?php
App::uses('AppController', 'Controller');
/**
 * Tipoinstituciones Controller
 *
 * @property Tipoinstitucion $Tipoinstitucion
 * @property PaginatorComponent $Paginator
 */
class TipoinstitucionesController extends AppController {

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
		$this->Tipoinstitucion->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->Tipoinstitucion->displayField)?$this->Tipoinstitucion->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['Tipoinstitucion'][$campo] = $nombre ;
			$conditions = array('conditions' => array('Tipoinstitucion.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('tipoinstituciones', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Tipoinstitucion->exists($id)) {
			throw new NotFoundException(__('Invalid tipoinstitucion'));
		}
		$options = array('conditions' => array('Tipoinstitucion.' . $this->Tipoinstitucion->primaryKey => $id));
		$this->set('tipoinstitucion', $this->Tipoinstitucion->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tipoinstitucion->create();
			if ($this->Tipoinstitucion->save($this->request->data)) {
				$this->Flash->success(__('The tipoinstitucion has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The tipoinstitucion could not be saved. Please, try again.'));
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
		if (!$this->Tipoinstitucion->exists($id)) {
			throw new NotFoundException(__('Invalid tipoinstitucion'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Tipoinstitucion->save($this->request->data)) {
				$this->Flash->success(__('The tipoinstitucion has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The tipoinstitucion could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Tipoinstitucion.' . $this->Tipoinstitucion->primaryKey => $id));
			$this->request->data = $this->Tipoinstitucion->find('first', $options);
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
		$this->Tipoinstitucion->id = $id;
		if (!$this->Tipoinstitucion->exists()) {
			throw new NotFoundException(__('Invalid tipoinstitucion'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Tipoinstitucion->delete()) {
			$this->Flash->success(__('The tipoinstitucion has been deleted.'));
		} else {
			$this->Flash->error(__('The tipoinstitucion could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
