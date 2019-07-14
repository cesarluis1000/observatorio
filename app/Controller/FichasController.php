<?php
App::uses('AppController', 'Controller');
/**
 * Fichas Controller
 *
 * @property Ficha $Ficha
 * @property PaginatorComponent $Paginator
 */
class FichasController extends AppController {
    
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
		$this->Ficha->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->Ficha->displayField)?$this->Ficha->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['Ficha'][$campo] = $nombre ;
			$conditions = array('conditions' => array('Ficha.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('fichas', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Ficha->exists($id)) {
			throw new NotFoundException(__('Invalido(a) ficha'));
		}
		$options = array('conditions' => array('Ficha.' . $this->Ficha->primaryKey => $id));
		$this->set('ficha', $this->Ficha->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
	    $a_sexo = array('Hombre'=>'Hombre','Mujer'=>'Mujer');
	    $a_boca = array('Pequeña'=>'Pequeña','Mediana'=>'Mediana','Grande'=>'Grande');
	    $a_labios = array('Delgados'=>'Delgados','Medianos'=>'Medianos','Grueso'=>'Grueso');
	    $a_compexion = array('Delgado'=>'Delgado','Robusto'=>'Robusto','Grueso'=>'Grueso','Obeso'=>'Obeso');
		if ($this->request->is('post')) {
			$this->Ficha->create();
			if ($this->Ficha->save($this->request->data)) {
				$this->Flash->success(__('El/la ficha se ha guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('No se pudo guardar el/la ficha. Por favor, int�ntelo de nuevo.'));
			}
		}
		$this->set(compact('a_sexo','a_boca','a_labios','a_compexion'));
	}
	

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
	    $a_sexo = array('Hombre'=>'Hombre','Mujer'=>'Mujer');
	    $a_boca = array('Pequeña'=>'Pequeña','Mediana'=>'Mediana','Grande'=>'Grande');
	    $a_labios = array('Delgados'=>'Delgados','Medianos'=>'Medianos','Grueso'=>'Grueso');
	    $a_compexion = array('Delgado'=>'Delgado','Robusto'=>'Robusto','Grueso'=>'Grueso','Obeso'=>'Obeso');
		if (!$this->Ficha->exists($id)) {
			throw new NotFoundException(__('Invalido(a) ficha'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Ficha->save($this->request->data)) {
				$this->Flash->success(__('El/la ficha se ha guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('No se pudo guardar el/la ficha. Por favor, int�ntelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Ficha.' . $this->Ficha->primaryKey => $id));
			$this->request->data = $this->Ficha->find('first', $options);
		}
		$this->set(compact('a_sexo','a_boca','a_labios','a_compexion'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Ficha->id = $id;
		if (!$this->Ficha->exists()) {
			throw new NotFoundException(__('Invalid ficha'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Ficha->delete()) {
			$this->Flash->success(__('El/la ficha ha sido borrado.'));
		} else {
			$this->Flash->error(__('El/la ficha no ha sido borrado. Por favor int�ntelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
