<?php
App::uses('AppController', 'Controller');
/**
 * Presos Controller
 *
 * @property Preso $Preso
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class PresosController extends AppController {

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
		$this->Preso->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->Preso->displayField)?$this->Preso->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){
		    $nombre = $this->request->query[$campo];
			$this->request->data['Preso'][$campo] = $nombre ;
			$conditions = array('conditions' => array('Preso.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('presos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Preso->exists($id)) {
			throw new NotFoundException(__('Invalid preso'));
		}
		$options = array('conditions' => array('Preso.' . $this->Preso->primaryKey => $id));
		$this->set('preso', $this->Preso->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Preso->create();
			if ($this->Preso->save($this->request->data)) {
				$this->Flash->success(__('The preso has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The preso could not be saved. Please, try again.'));
			}
		}
		$tipoDocumentos = $this->Preso->TipoDocumento->find('list');
		$estabPenitenciarios = $this->Preso->EstabPenitenciario->find('list');
		//$delitoEspecificos = $this->Preso->DelitoEspecifico->find('list');
		$delitoEspecificos = $this->Preso->DelitoEspecifico->find('list', array('fields' => array('DelitoEspecifico.nombre')));
		$origenPenitenciarios = $this->Preso->OrigenPenitenciario->find('list');
		$this->set(compact('tipoDocumentos', 'estabPenitenciarios', 'delitoEspecificos', 'origenPenitenciarios'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Preso->exists($id)) {
			throw new NotFoundException(__('Invalid preso'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Preso->save($this->request->data)) {
				$this->Flash->success(__('The preso has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The preso could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Preso.' . $this->Preso->primaryKey => $id));
			$this->request->data = $this->Preso->find('first', $options);
		}
		$tipoDocumentos = $this->Preso->TipoDocumento->find('list');
		$estabPenitenciarios = $this->Preso->EstabPenitenciario->find('list');
		//$delitoEspecificos = $this->Preso->DelitoEspecifico->find('list');
		$delitoEspecificos = $this->Preso->DelitoEspecifico->find('list', array('fields' => array('DelitoEspecifico.nombre')));
		$origenPenitenciarios = $this->Preso->OrigenPenitenciario->find('list');
		$this->set(compact('tipoDocumentos', 'estabPenitenciarios', 'delitoEspecificos', 'origenPenitenciarios'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Preso->id = $id;
		if (!$this->Preso->exists()) {
			throw new NotFoundException(__('Invalid preso'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Preso->delete()) {
			$this->Flash->success(__('The preso has been deleted.'));
		} else {
			$this->Flash->error(__('The preso could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
