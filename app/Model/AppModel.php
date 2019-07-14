<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    
    private function getCurrentUser() {
        App::uses('CakeSession', 'Model/Datasource');
        $Session = new CakeSession();
        $user = $Session->read('Auth.User');    
        return $user;
    }
    
    public function beforeSave($options = array()) {
        
        //Editar
        if (isset($this->data[$this->alias]['id']) && $this->data[$this->alias]['id'] > 0 && isset($this->data[$this->alias]['modificador']) && isset($this->data[$this->alias]['modificado'])){
            $user = $this->getCurrentUser();           
            $this->data[$this->alias]['modificador'] = $user['username'];
            $this->data[$this->alias]['modificado'] = date("Y-m-d H:i:s");
        }//Agregar
        if (!isset($this->data[$this->alias]['id']) && isset($this->data[$this->alias]['creador']) && isset($this->data[$this->alias]['creado'])){
            $user = $this->getCurrentUser();
            $this->data[$this->alias]['creador'] = $user['username'];
            $this->data[$this->alias]['creado'] = date("Y-m-d H:i:s");
        }
       return true;
    }
}
