<?php
class PermisosController extends AppController {

	public $uses = array();

	public function roles() {
		
		$params = array('conditions' => array('Aro.model' => 'Group'),'recursive' => 0);	    
	    $data0 = $this->Acl->Aro->find('all', $params);
		$this->loadModel('User');
		
		foreach ($data0 as $key => $item){
		    
		    //Lista de accesos de controladores 
		    $data[$item['Aro']['id'].'|'] = $item['Aro']['alias'];
		    $sql = "SELECT * FROM (SELECT aco.id as aco_id, CONCAT({$item['Aro']['foreign_key']},'|',aco.id) as id, CONCAT('|',aco.alias,' ',aa._create) as alias ,aro.id as aro_id FROM aros AS aro
                        LEFT JOIN aros_acos AS aa ON aro.id = aa.aro_id
                            LEFT JOIN acos AS aco ON aco.id = aa.aco_id
                    WHERE aro.parent_id IS NULL AND (aco.parent_id IS NULL OR aco.parent_id = 1)
                    AND aro.id={$item['Aro']['id']} AND aco.id IS NOT NULL) acos";
		    $row = $this->User->query($sql);
		    
		    //Cuando no tiene ningun acceso
		    $results = Set::extract('/acos/alias', $row);
		    if (in_array("|controllers 1", $results) || in_array("|controllers -1", $results) ){		        
		    }else{
		        $row[] = array('acos'=> array('aco_id'=>'1','id'=>"{$item['Aro']['foreign_key']}|1",'alias'=>'|controllers -1'));
		        $row = Set::sort($row, '{n}.acos.aco_id', 'asc');
		    }
		    
		    foreach ($row as $rw){
		        
		        //Lista de accesos de acciones
		        $sql = "SELECT * FROM (SELECT CONCAT('{$rw['acos']['id']}','|',aco.id) as id, CONCAT('||',aco.alias,' ',if(aa._create is null,1,aa._create)) as alias 
		                  FROM acos AS aco
                            LEFT JOIN aros_acos AS aa ON aa.aro_id = {$item['Aro']['id']}  AND aco.id = aa.aco_id
                        WHERE aco.parent_id={$rw['acos']['aco_id']}  ORDER BY aco.id) acos";
		        $row2 = $this->User->query($sql);
		        //pr($row2);
		        $rowList = array($rw['acos']['id']=>$rw['acos']['alias']);
		        $rowList2 = Set::combine($row2, '{n}.acos.id', '{n}.acos.alias');
		        $data = array_merge($data,$rowList);
		       
		        $data = array_merge($data,$rowList2);
		    }
		   
		}
		//pr($data);
		$this->set(compact('data'));
	}
	
	public function acceso($tipo,$aro_id,$aco_id){
	    $params = array('conditions' => array('Aco.id' => $aco_id),'recursive' => 0);	    
	    $data = $this->Acl->Aco->find('first', $params);
	    
	    $conditions = array('Aco.lft <='=>$data['Aco']['lft'],'Aco.rght >='=>$data['Aco']['lft']);
	    $data = $this->Acl->Aco->generateTreeList($conditions,'{n}.Aco.id','{n}.Aco.alias',null);
	    $alias = implode('/', $data);
	    
	       App::import('Model','Group');
	       $this->Group = new Group();
	       $this->Group->id = $aro_id;
	       if ($tipo == 1){
	           $this->Acl->allow($this->Group, $alias);
	       }
	       if ($tipo == 0){
	           $this->Acl->deny($this->Group, $alias);
	       }
	       $this->Flash->success(__('Accesos modificados'));
	       return $this->redirect(array('action' => 'roles'));
	}
	
	public function aplicaciones() {
		$conditions = array('Aro.lft >='=>'1','Aro.rght <='=>'4');
		$conditions = null;
		$data = $this->Acl->Aco->generateTreeList($conditions,'{n}.Aco.id','{n}.Aco.alias','|');
		//pr($data);
		$this->set(compact('data'));
	}
	
	public function add($aco_id){
	   	    
	    if ($this->request->is(array('post', 'put'))) {
	        $parent_id = $this->request->data['Permisos']['parent_id'];
	        $alias = $this->request->data['Permisos']['alias'];
	        $this->Acl->Aco->create(array('parent_id' => $parent_id, 'alias' => $alias));
	        $this->Acl->Aco->save();
	        $this->Flash->success(__('Aplicacion creado'));
	        return $this->redirect(array('action' => 'aplicaciones'));
	    }else{
    	    $params = array('conditions' => array('Aco.id' => $aco_id),'recursive' => 0);	    
    	    $aco = $this->Acl->Aco->find('first', $params);    	    
    	    $conditions = array('Aco.lft <='=>$aco['Aco']['lft'],'Aco.rght >='=>$aco['Aco']['lft']);
    	    $data = $this->Acl->Aco->generateTreeList($conditions,'{n}.Aco.id','{n}.Aco.alias',null);
    	    $alias = implode('/', $data);
    	    $this->set(compact('aco_id','alias'));
	    }
	}
	
	public function edit($aco_id){
		if ($this->request->is(array('post', 'put'))) {
	        $id = $this->request->data['Permisos']['id'];
	        $alias = $this->request->data['Permisos']['alias'];
	        $this->Acl->Aco->save(array('id' => $id, 'alias' => $alias));
	        $this->Flash->success(__('Aplicacion editado'));
	        return $this->redirect(array('action' => 'aplicaciones'));
	    }else{
    	    $params = array('conditions' => array('Aco.id' => $aco_id),'recursive' => 0);	    
    	    $aco = $this->Acl->Aco->find('first', $params);    	    
    	    $conditions = array('Aco.lft <='=>$aco['Aco']['lft'],'Aco.rght >='=>$aco['Aco']['lft']);
    	    $data = $this->Acl->Aco->generateTreeList($conditions,'{n}.Aco.id','{n}.Aco.alias',null);
    	    $alias = implode('/', $data);
    	    $this->set(compact('aco','alias'));
	    }
	}
	
	public function delete($aco_id){
	        $this->Acl->Aco->delete(array('id' => $aco_id));
	        $this->Flash->success(__('Aplicacion eliminada'));
	        return $this->redirect(array('action' => 'aplicaciones'));
	}
}