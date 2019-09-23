<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $components = array(
        'Acl','RequestHandler',//'DebugKit.Toolbar',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
			//Ruta de logeo
            'loginRedirect' => array(
                'controller' => 'Reportes',
                'action' => 'mapaDelito'
            ),
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            )
        ),
         'Paginator', 'Session', 'Flash'
    );
    public $helpers = array('Html', 'Form', 'Session');

	public $a_estados;
    function beforeFilter(){
        ini_set('max_execution_time', 300);
        ini_set('precision',16);
        $this->paginate = array('limit'=>200);
		$this->a_estados = array('A'=>'Activo','D'=>'Desactivo');
		$this->set('a_estados',$this->a_estados);
		
		$this->Auth->unauthorizedRedirect=FALSE ;
		$this->Auth->authError=__('You are not authorized to access that location.');		
		$this->Auth->allow('login','logout','display','index','mapaDelito',
		    'delitosgeojson','delitosgeojson','institucionesgeojson','geojson','listjson',
		    'panamericanosgeojson','panamericanos'
		    );
		
		$this->__checkAuth();
		$this->__observatorio();
    }

    private function __observatorio(){
        //Acciones que utilizarar el layout observatorio
        
        $this->acciones_ecommerce = array('panamericanos');
        if (in_array($this->action, $this->acciones_ecommerce)){
            //$this->layout = 'observatorio';
        }    
    }
    
    private function __checkAuth() {
        $currentUser = $this->Auth->user();
        //pr($currentUser);
        if(!empty($currentUser)){
           $params = array('conditions' => array('Aro.model' => 'group', 'Aro.foreign_key' => $currentUser['Group']['id']),'order' => 'Aro.lft','recursive' => 0);
           $aro = $this->Acl->Aro->find('first',$params);
           //pr($aro);
           $this->loadModel('Menu');
           $this->Menu->unbindModel(array('belongsTo' => array('ParentMenu')));
           $this->Menu->unbindModel(array('hasMany' => array('ChildMenu')));
           $params1 = array('conditions' => array('Menu.aro_id' => $aro['Aro']['id'],'Menu.parent_id' => ''),'order' => 'Menu.lft');
           $a_menu = $this->Menu->find('all',$params1);
           foreach ($a_menu as $id => $item){
               
               $this->Menu->unbindModel(array('belongsTo' => array('ParentMenu')));
               $this->Menu->unbindModel(array('hasMany' => array('ChildMenu')));
               $params2 = array('conditions' => array('Menu.parent_id' => $item['Menu']['id']),'order' => 'Menu.lft');
               $a_menu1 = $this->Menu->find('all',$params2);
               
               foreach ($a_menu1 as $id1 => $item1){
                  $params3 = array('conditions' => array('Aco.id' => $item1['Aco']['parent_id']),'recursive' => 0);
                  $a_aco_controlador = $this->Acl->Aco->find('first',$params3);
                  $a_menu1[$id1]['Controlador'] = $a_aco_controlador['Aco'];
               }
               
               $a_menu[$id]['Acciones'] = $a_menu1;
           }
        }
        $this->set(compact('a_menu','currentUser'));
    }
}
