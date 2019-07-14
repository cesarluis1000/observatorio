<?php
App::uses('AppController', 'Controller');
/**
 * Menus Controller
 *
 * @property Menu $Menu
 * @property PaginatorComponent $Paginator
 */
class MenusController extends AppController {

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
	    
	    $params = array('conditions' => array('Aro.model' => 'Group'),'recursive' => 0);
	    $data0 = $this->Acl->Aro->find('all', $params);
	    foreach ($data0 as $key => $item){
	        $params2 = array('conditions' => array('Menu.aro_id' => $item['Aro']['id'], 'Menu.parent_id' => ''),'recursive' => 1);	        
	        $data1 = $this->Menu->find('all', $params2);
	        //Registramos los grupos
	        $data[$item['Aro']['id']] = $item['Aro']['alias'];
	        foreach ($data1 as $key1 => $item1){
	            //Registramos de los grupos de menu (Permisos)
	            $data[$item['Aro']['id'].'|'.$item1['Menu']['id']] = '|'.$item1['Menu']['nombre'];
	            foreach ($item1['ChildMenu'] as $key2 => $item2){
	                //Registramos los link del menu (Grupos, Usuario)
	                $data[$item['Aro']['id'].'|'.$item1['Menu']['id'].'|'.$item2['id']] = '||'.$item2['nombre'];
	            }
	        }	        
	    }
		$this->set(compact('data'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Menu->exists($id)) {
			throw new NotFoundException(__('Invalid menu'));
		}
		$options = array('conditions' => array('Menu.' . $this->Menu->primaryKey => $id));
		$this->set('menu', $this->Menu->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($ids) {
	    if ($this->request->is(array('post', 'put'))) {
	        //Registrar nuevo menu
	        $menu    = $this->request->data['Menu'];
	        $this->Menu->create($menu);
	        $this->Menu->save();
	        $this->Flash->success(__('Menu creado'));
	        return $this->redirect(array('action' => 'index'));	        
	    }else{
	        $a_id = explode('|', $ids);
	        $aro_id =$a_id[0];
	        $parend_id =null;
	        $a_aplicaciones = null;
	        $params = array('conditions' => array('Aro.id' => $aro_id),'recursive' => 0);
	        $a_aro = $this->Acl->Aro->find('first', $params);
	        $alias = __('Group').':'.$a_aro['Aro']['alias'];
	        if (isset($a_id[1])){
	            $params = array('conditions' => array('Menu.id' => $a_id[1]),'recursive' => 0);
	            $menu = $this->Menu->find('first', $params);
	            $alias = $alias.' Menu:'.$menu['Menu']['nombre'];
	            $parend_id =$a_id[1];
	            $conditions = array('Aco.parent_id' => 1);
	            $a_acos_controladores = $this->Acl->Aco->generateTreeList($conditions,'{n}.Aco.id','{n}.Aco.alias',null);
	            foreach ($a_acos_controladores as $parent_id => $aco){
	                $conditions = array('Aco.parent_id' => $parent_id);
	                $a_acos_acciones = $this->Acl->Aco->generateTreeList($conditions,'{n}.Aco.id','{n}.Aco.alias',null);
	                foreach ($a_acos_acciones as $id => $aco2){
	                   $a_aplicaciones[$id] = $aco.'/'.$aco2;
	                }
	            }
	        }    	   
    	    $this->set(compact('a_aplicaciones','aro_id','parend_id','alias'));
	    }
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($ids = null) {
		if ($this->request->is(array('post', 'put'))) {
	        //Registrar nuevo menu
	        $menu    = $this->request->data['Menu'];
	        $this->Menu->create($menu);
	        $this->Menu->save();
	        $this->Flash->success(__('Menu creado'));
	        return $this->redirect(array('action' => 'index'));	        
	    }else{
	        $a_id = explode('|', $ids);
	        $aro_id =$a_id[0];
	        $parend_id =null;
	        $a_aplicaciones = null;
	        $params = array('conditions' => array('Aro.id' => $aro_id),'recursive' => 0);
	        $a_aro = $this->Acl->Aro->find('first', $params);
	        $alias = __('Group').':'.$a_aro['Aro']['alias'];
	        
	        $menu_id = end($a_id);
	        $params = array('conditions' => array('Menu.id' =>$menu_id),'recursive' => 0);
	        $menu = $this->Menu->find('first', $params);
	        $nombre = $menu['Menu']['nombre'];
	        $aco_id = $menu['Menu']['aco_id'];
	 ;
	        if (isset($a_id[2])){
	            $params = array('conditions' => array('Menu.id' => $a_id[1]),'recursive' => 0);
	            $menu = $this->Menu->find('first', $params);
	            $alias = $alias.' Menu:'.$menu['Menu']['nombre'];
	            $parend_id =$a_id[1];
	            $conditions = array('Aco.parent_id' => 1);
	            $a_acos_controladores = $this->Acl->Aco->generateTreeList($conditions,'{n}.Aco.id','{n}.Aco.alias',null);
	            foreach ($a_acos_controladores as $parent_id => $aco){
	                $conditions = array('Aco.parent_id' => $parent_id);
	                $a_acos_acciones = $this->Acl->Aco->generateTreeList($conditions,'{n}.Aco.id','{n}.Aco.alias',null);
	                foreach ($a_acos_acciones as $id => $aco2){
	                   $a_aplicaciones[$id] = $aco.'/'.$aco2;
	                }
	            }
	        }
	        
    	    $this->set(compact('a_aplicaciones','aro_id','aco_id','parend_id','alias','menu_id','nombre'));
	    }
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($ids = null) {
	    $a_id = explode('|', $ids);
	    $menu_id = end($a_id);
		$this->Menu->id = $menu_id;
		if (!$this->Menu->exists()) {
			throw new NotFoundException(__('Invalid menu'));
		}
		//pr($id); exit;
		//$this->request->allowMethod('post', 'delete');
		if ($this->Menu->delete()) {
			$this->Flash->success(__('The menu has been deleted.'));
		} else {
			$this->Flash->error(__('The menu could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
