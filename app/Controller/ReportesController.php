<?php
App::uses('AppController', 'Controller');

class ReportesController extends AppController {
    
    public $reportes = array();
    
    public function panamericanos(){
        $this->loadModel('Departamento');
        $this->loadModel('Provincia');
        $this->loadModel('Distrito');
        $this->loadModel('Denuncia');
        
        /********Filtros momentaneos para Perla y Iquitos*******/
        $currentUser = $this->Auth->user();               
        unset($this->request->query['n']);
        //pr($currentUser);                
        /********Filtros momentaneos para Perla y Iquitos*******/
        $currentUser = $this->Auth->user();
        if(!empty($currentUser['username']) && empty($this->request->query)){
            $filtros = null;
            switch ($currentUser['username']){
                case 'cramos': $filtros = Array
                (
                'departamento_id' => 15,
                'provincia_id' => 112,
                'distrito_id' => 842,
                'fecha_de' => '2019-08-01',
                'hasta' => '2019-09-30',
                'horas' => '12:00 AM - 11:59 PM',
                'horas1' => 0,
                'horas2' => 24
                );
                break;
                default:
                    $filtros = Array
                    (
                    'departamento_id' => 15,
                    'provincia_id' => 112,
                    'distrito_id' => 842,
                    'fecha_de' => '2019-09-01',
                    'hasta' => '2019-09-15',
                    'horas' => '12:00 AM - 11:59 PM',
                    'horas1' => 0,
                    'horas2' => 24
                    );
            }
            $this->request->query = $filtros;
        }
                        
        /********Filtros momentaneos para Perla y Iquitos*******/               
        
        $options = array('recursive'=>-1);
        $departamentos = $this->Departamento->find('list',$options);
        
        //pr($this->request->query);
        $conditions = array();
        $provincias = null;
        if (isset($this->request->query['departamento_id'])){
            $departamento_id = $this->request->data['Reportes']['departamento_id'] = $this->request->query['departamento_id'];
            $options = array('conditions' => array('departamento_id' => $departamento_id),
                'recursive' => -1
            );
            $provincias = $this->Provincia->find('list',$options);
        }else{
            $departamento_id = 0;
        }
        
        $distritos = null;
        $a_distrito_id = null;
        if (isset($this->request->query['provincia_id']) && !empty($this->request->query['provincia_id'])){
            $provincia_id = $provincia_ids = $this->request->data['Reportes']['provincia_id'] = $this->request->query['provincia_id'];
            $options = array('conditions' => array('provincia_id' => $provincia_id),
                'order' =>array('Distrito.nombdist' => 'asc'),
                'recursive' => -1
            );
            $distritos = $this->Distrito->find('list',$options);
            
        }else{
            $options           = array('fields'     => array('DISTINCT id'),
                'conditions'   =>  array('departamento_id' => $departamento_id),
                'recursive'  => -1);
            $provincias_act    = $this->Distrito->Provincia->find('all',$options);
            $provincia_ids     = Hash::extract($provincias_act, '{n}.Provincia.id');
        }
        
        if (isset($this->request->query['distrito_id']) && !empty($this->request->query['distrito_id'])){
            
            $distrito_id = $distrito_ids = $this->request->data['Reportes']['distrito_id'] = $this->request->query['distrito_id'];
            
            $options = array('conditions' => array('Distrito.id' => $distrito_id),
                'order' =>array('Distrito.nombdist' => 'asc'),
                'recursive' => -1
            );
            
            $distrito = $this->Distrito->find('first',$options);
            $distrito['Distrito']['nombdist'] = ucwords(strtolower($distrito['Distrito']['nombdist']));
        }else{
            $options           = array( 'fields'     =>  array('DISTINCT id'),
                'conditions' =>  array('provincia_id' => $provincia_ids),
                'recursive'  =>  -1);
            $polygon_activo    = $this->Distrito->find('all',$options);
            $distrito_ids      = Hash::extract($polygon_activo, '{n}.Distrito.id');
        }
        
        
        //$distrito['Distrito']['nombdist'] = ucwords(strtolower($distrito['Distrito']['nombdist']));
        
        if (isset($this->request->query['fecha_de'])){
            $this->request->data['Reportes']['fecha_de'] = $this->request->query['fecha_de'];
        }else{
            $this->request->data['Reportes']['fecha_de'] = '2019-03-31';
        }
        
        if (isset($this->request->query['hasta'])){
            $this->request->data['Reportes']['hasta'] = $this->request->query['hasta'];
        }else{
            $this->request->data['Reportes']['hasta'] = '2019-03-31';
        }
        
        if (isset($this->request->query['ghostZoom'])){
            $this->request->data['Reportes']['ghostZoom'] = $this->request->query['ghostZoom'];
        }
        
        if (isset($this->request->query['centroZoom'])){
            $this->request->data['Reportes']['centroZoom'] = $this->request->query['centroZoom'];
        }
        
        if (isset($this->request->query['horas'])){
            $horas = $this->request->data['Reportes']['horas'] = $this->request->query['horas'];
            $horas = explode(' - ', $horas);
            //pr($horas);
            
            $horas1 = explode(':', $horas[0]);
            //pr($horas1);
            $pos = strpos($horas[0], 'PM');
            if($pos !== false && $horas1[0] != 12){
                $horas1[0] +=12;
            }
            
            $pos = strpos($horas[0], 'AM');
            if($pos !== false && $horas1[0] == 12){
                $horas1[0] =0;
            }
            
            $horas1 = $horas1[0];
            
            $horas2 = explode(':', $horas[1]);
            $pos = strpos($horas[1], 'PM');
            if($pos !== false && $horas2[0] != 12){
                $horas2[0] +=12;
            }
            
            $pos = strpos($horas[1], 'AM');
            if($pos !== false && $horas2[0] == 12){
                $horas2[0] =0;
            }
            if ($horas[1] == '11:59 PM'){
                $horas2[0] =24;
            }
            
            $horas2 = $horas2[0];
            
        }else{
            $this->request->data['Reportes']['horas'] = '12:00 AM - 11:59 PM';
            $horas1 = '0';
            $horas2 = '24';
        }
        
        //Categorias para juegos panamericanos
        $categoria = array('HURTO','ROBO','VIOLENCIA SEXUAL','ESTAFA','DROGAS','SECUESTRO','HOMICIDIO');
        $denuncias = $this->Denuncia->find('all', array('fields'        => array('DISTINCT Denuncia.categoria'),
                                                        'conditions'    => array('categoria' => $categoria)    
                                            ));
        
        $ckdAll = false;
        if (isset($this->request->query['ckdAll'])){
            $ckdAll = true;
            $this->request->data['Reportes']['ckdAll'] = 'checked';
        }else{
            $this->request->data['Reportes']['ckdAll'] = false;
        }
        
        $conditions = array_merge($conditions,array("distrito_id"=> $distrito_ids));
        $conditions = array_merge($conditions,array("estado_google"=> 'OK'));
        $conditions = array_merge($conditions,array("fecha_hecho >=" => $this->request->data['Reportes']['fecha_de']));
        $conditions = array_merge($conditions,array("fecha_hecho <=" => $this->request->data['Reportes']['hasta']));
        $conditions = array_merge($conditions,array("HOUR(fecha_hecho) >=" => $horas1));
        $conditions = array_merge($conditions,array("HOUR(fecha_hecho) <=" => $horas2));
        $conditions = array_merge($conditions,array("categoria" => $categoria));
        //pr($conditions);
        
        $options = array('fields' => array('Denuncia.id'),
            'conditions'=> $conditions
        );
        
        $total = $this->Denuncia->find('count',$options);
        
        if (!empty($denuncias)){
            
            foreach ($denuncias as $i => $denuncia){
                
                $conditions = array_merge($conditions,array('Denuncia.categoria' => $denuncia['Denuncia']['categoria']));
                $options = null;
                //pr($conditions);
                $options = array('fields' => array('Denuncia.id'),
                    'conditions'=> $conditions
                );
                
                $subTotal = $this->Denuncia->find('count',$options);
                
                $denuncias[$i]['Denuncia']['id'] = strtolower(str_replace(' ', '_', $denuncia['Denuncia']['categoria']));
                $denuncias[$i]['Denuncia']['img'] = "./img/map/".strtolower(str_replace(' ', '_', $denuncia['Denuncia']['categoria'])).'_20px.png';
                $denuncias[$i]['Denuncia']['subTotal'] = $subTotal;
                
                $checked = false;
                if (isset($this->request->query['delito'][$denuncias[$i]['Denuncia']['id']]) || $ckdAll){
                    $checked = 'checked';
                }
                $denuncias[$i]['Denuncia']['checked'] = $checked;
                
            }
        }
        
        if (isset($this->request->query['delito'])){
            $this->request->data['Reportes']['delito'] = $this->request->query['delito'];
        }
        
        //pr($denuncias);
        
        $this->set(compact('departamentos','provincias','distritos','distrito', 'denuncias','total','horas1','horas2'));
    }
    
    public function mapaPresos(){
        /********Filtros momentaneos para Perla y Iquitos*******/
        $currentUser = $this->Auth->user();
        if(!empty($currentUser['username']) && empty($this->request->query)){
            $filtros = null;
            switch ($currentUser['username']){
                case 'cramos': $filtros = Array
                                (
                                'departamento_id' => 15,
                                'provincia_id' => 112,
                                'distrito_id' => 842,
                                'fecha_de' => '2019-08-01',
                                'hasta' => '2019-09-30',
                                'horas' => '12:00 AM - 11:59 PM',
                                'horas1' => 0,
                                'horas2' => 24
                                );
                break;
                default:
                    $filtros = Array
                    (
                    'departamento_id' => 15,
                    'provincia_id' => 112,
                    'distrito_id' => 842,
                    'fecha_de' => '2019-09-01',
                    'hasta' => '2019-09-15',
                    'horas' => '12:00 AM - 11:59 PM',
                    'horas1' => 0,
                    'horas2' => 24
                    );
            }
            $this->request->query = $filtros;
        }
        /********Filtros momentaneos para Perla y Iquitos*******/
        
        
        $this->loadModel('Departamento');
        $this->loadModel('Provincia');
        $this->loadModel('Distrito');
        $this->loadModel('Denuncia');
        
        $options = array('recursive'=>-1);
        $departamentos = $this->Departamento->find('list',$options);
        
        //pr($this->request->query);
        $conditions = array();
        $provincias = null;
        if (isset($this->request->query['departamento_id'])){
            $departamento_id = $this->request->data['Reportes']['departamento_id'] = $this->request->query['departamento_id'];
            $options = array('conditions' => array('departamento_id' => $departamento_id),
                'recursive' => -1
            );
            $provincias = $this->Provincia->find('list',$options);
        }else{
            $departamento_id = 0;
        }
        
        $distritos = null;
        $a_distrito_id = null;
        if (isset($this->request->query['provincia_id']) && !empty($this->request->query['provincia_id'])){
            $provincia_id = $provincia_ids = $this->request->data['Reportes']['provincia_id'] = $this->request->query['provincia_id'];
            $options = array('conditions' => array('provincia_id' => $provincia_id),
                'order' =>array('Distrito.nombdist' => 'asc'),
                'recursive' => -1
            );
            $distritos = $this->Distrito->find('list',$options);
            
        }else{
            $options           = array('fields'     => array('DISTINCT id'),
                'conditions'   =>  array('departamento_id' => $departamento_id),
                'recursive'  => -1);
            $provincias_act    = $this->Distrito->Provincia->find('all',$options);
            $provincia_ids     = Hash::extract($provincias_act, '{n}.Provincia.id');
        }
        
        if (isset($this->request->query['distrito_id']) && !empty($this->request->query['distrito_id'])){
            
            $distrito_id = $distrito_ids = $this->request->data['Reportes']['distrito_id'] = $this->request->query['distrito_id'];
            
            $options = array('conditions' => array('Distrito.id' => $distrito_id),
                'order' =>array('Distrito.nombdist' => 'asc'),
                'recursive' => -1
            );
            
            $distrito = $this->Distrito->find('first',$options);
            $distrito['Distrito']['nombdist'] = ucwords(strtolower($distrito['Distrito']['nombdist']));
        }else{
            $options           = array( 'fields'     =>  array('DISTINCT id'),
                'conditions' =>  array('provincia_id' => $provincia_ids),
                'recursive'  =>  -1);
            $polygon_activo    = $this->Distrito->find('all',$options);
            $distrito_ids      = Hash::extract($polygon_activo, '{n}.Distrito.id');
        }
        
        
        //$distrito['Distrito']['nombdist'] = ucwords(strtolower($distrito['Distrito']['nombdist']));
        
        if (isset($this->request->query['fecha_de'])){
            $this->request->data['Reportes']['fecha_de'] = $this->request->query['fecha_de'];
        }else{
            $this->request->data['Reportes']['fecha_de'] = '2019-03-31';
        }
        
        if (isset($this->request->query['hasta'])){
            $this->request->data['Reportes']['hasta'] = $this->request->query['hasta'];
        }else{
            $this->request->data['Reportes']['hasta'] = '2019-03-31';
        }
        
        if (isset($this->request->query['ghostZoom'])){
            $this->request->data['Reportes']['ghostZoom'] = $this->request->query['ghostZoom'];
        }
        
        if (isset($this->request->query['centroZoom'])){
            $this->request->data['Reportes']['centroZoom'] = $this->request->query['centroZoom'];
        }
        
        if (isset($this->request->query['horas'])){
            $horas = $this->request->data['Reportes']['horas'] = $this->request->query['horas'];
            $horas = explode(' - ', $horas);
            //pr($horas);
            
            $horas1 = explode(':', $horas[0]);
            //pr($horas1);
            $pos = strpos($horas[0], 'PM');
            if($pos !== false && $horas1[0] != 12){
                $horas1[0] +=12;
            }
            
            $pos = strpos($horas[0], 'AM');
            if($pos !== false && $horas1[0] == 12){
                $horas1[0] =0;
            }
            
            $horas1 = $horas1[0];
            
            $horas2 = explode(':', $horas[1]);
            $pos = strpos($horas[1], 'PM');
            if($pos !== false && $horas2[0] != 12){
                $horas2[0] +=12;
            }
            
            $pos = strpos($horas[1], 'AM');
            if($pos !== false && $horas2[0] == 12){
                $horas2[0] =0;
            }
            if ($horas[1] == '11:59 PM'){
                $horas2[0] =24;
            }
            
            $horas2 = $horas2[0];
            
        }else{
            $this->request->data['Reportes']['horas'] = '12:00 AM - 11:59 PM';
            $horas1 = '0';
            $horas2 = '24';
        }
        
        //pr($horas1);
        //pr($horas2);
        
        $denuncias = $this->Denuncia->find('all', array('fields' => array('DISTINCT Denuncia.categoria')));
        
        $ckdAll = false;
        if (isset($this->request->query['ckdAll'])){
            $ckdAll = true;
            $this->request->data['Reportes']['ckdAll'] = 'checked';
        }else{
            $this->request->data['Reportes']['ckdAll'] = false;
        }
        
        $conditions = array_merge($conditions,array("distrito_id"=> $distrito_ids));
        $conditions = array_merge($conditions,array("estado_google"=> 'OK'));
        $conditions = array_merge($conditions,array("fecha_hecho >=" => $this->request->data['Reportes']['fecha_de']));
        $conditions = array_merge($conditions,array("fecha_hecho <=" => $this->request->data['Reportes']['hasta']));
        $conditions = array_merge($conditions,array("HOUR(fecha_hecho) >=" => $horas1));
        $conditions = array_merge($conditions,array("HOUR(fecha_hecho) <=" => $horas2));
        //pr($conditions);
        
        $options = array('fields' => array('Denuncia.id'),
            'conditions'=> $conditions
        );
        
        $total = $this->Denuncia->find('count',$options);
        
        if (!empty($denuncias)){
            
            foreach ($denuncias as $i => $denuncia){
                
                $conditions = array_merge($conditions,array('Denuncia.categoria' => $denuncia['Denuncia']['categoria']));
                $options = null;
                //pr($conditions);
                $options = array('fields' => array('Denuncia.id'),
                    'conditions'=> $conditions
                );
                
                $subTotal = $this->Denuncia->find('count',$options);
                
                $denuncias[$i]['Denuncia']['id'] = strtolower(str_replace(' ', '_', $denuncia['Denuncia']['categoria']));
                $denuncias[$i]['Denuncia']['img'] = "./img/map/".strtolower(str_replace(' ', '_', $denuncia['Denuncia']['categoria'])).'_20px.png';
                $denuncias[$i]['Denuncia']['subTotal'] = $subTotal;
                
                $checked = false;
                if (isset($this->request->query['delito'][$denuncias[$i]['Denuncia']['id']]) || $ckdAll){
                    $checked = 'checked';
                }
                $denuncias[$i]['Denuncia']['checked'] = $checked;
                
            }
        }
        
        if (isset($this->request->query['delito'])){
            $this->request->data['Reportes']['delito'] = $this->request->query['delito'];
        }
        
        //pr($denuncias);
        
        $this->set(compact('departamentos','provincias','distritos','distrito', 'denuncias','total','horas1','horas2'));
        
    }
    
    public function mapaDelito() {
        
        //r($this->request->data);
        //pr($this->Auth->user());
        //pr($this->request->query);
        
        /********Filtros momentaneos para Perla y Iquitos*******/
        unset($this->request->query['n']);
        if(empty($this->request->query)){
            $filtros = Array
            (
                'departamento_id' => 15,
                'provincia_id' => 112,
                'distrito_id' => 860,
                'fecha_de' => '2019-09-01',
                'hasta' => '2019-09-30',
                'horas' => '12:00 AM - 11:59 PM',
                'horas1' => 0,
                'horas2' => 24,
                'delito'=> array('hurto'=>'on','robo'=>'on')
                );
            $this->request->query = $filtros;
        }
        
        /********Filtros momentaneos para Perla y Iquitos*******/
        
        
        $this->loadModel('Departamento');
        $this->loadModel('Provincia');
        $this->loadModel('Distrito');
        $this->loadModel('Denuncia');
        $this->loadModel('TipoDenuncia');
        
        $options = array('recursive'=>-1);
        $departamentos = $this->Departamento->find('list',$options);
        
        //pr($this->request->query);       
        $conditions = array();
        $provincias = null;
        if (isset($this->request->query['departamento_id'])){
            $departamento_id = $this->request->data['Reportes']['departamento_id'] = $this->request->query['departamento_id'];
            $options = array('conditions' => array('departamento_id' => $departamento_id),
                             'recursive' => -1
                            );
            $provincias = $this->Provincia->find('list',$options);
        }else{
            $departamento_id = 0;
        }
        
        $distritos = null;
        $a_distrito_id = null;
        if (isset($this->request->query['provincia_id']) && !empty($this->request->query['provincia_id'])){
            $provincia_id = $provincia_ids = $this->request->data['Reportes']['provincia_id'] = $this->request->query['provincia_id'];
            $options = array('conditions' => array('provincia_id' => $provincia_id),
                             'order' =>array('Distrito.nombdist' => 'asc'),
                             'recursive' => -1
                        );
            $distritos = $this->Distrito->find('list',$options);         
            
        }else{
            $options           = array('fields'     => array('DISTINCT id'),
                'conditions'   =>  array('departamento_id' => $departamento_id),
                'recursive'  => -1);
            $provincias_act    = $this->Distrito->Provincia->find('all',$options);
            $provincia_ids     = Hash::extract($provincias_act, '{n}.Provincia.id');
        }
        
        if (isset($this->request->query['distrito_id']) && !empty($this->request->query['distrito_id'])){
            
            $distrito_id = $distrito_ids = $this->request->data['Reportes']['distrito_id'] = $this->request->query['distrito_id'];           
                        
            $options = array('conditions' => array('Distrito.id' => $distrito_id),
                'order' =>array('Distrito.nombdist' => 'asc'),
                'recursive' => -1
            );
            
            $distrito = $this->Distrito->find('first',$options);
            $distrito['Distrito']['nombdist'] = ucwords(strtolower($distrito['Distrito']['nombdist']));
        }else{
            $options           = array( 'fields'     =>  array('DISTINCT id'),
                                        'conditions' =>  array('provincia_id' => $provincia_ids),
                                        'recursive'  =>  -1);
            $polygon_activo    = $this->Distrito->find('all',$options);
            $distrito_ids      = Hash::extract($polygon_activo, '{n}.Distrito.id');
        }
        

        //$distrito['Distrito']['nombdist'] = ucwords(strtolower($distrito['Distrito']['nombdist']));
        
        if (isset($this->request->query['fecha_de'])){
            $this->request->data['Reportes']['fecha_de'] = $this->request->query['fecha_de'];
        }else{
            $this->request->data['Reportes']['fecha_de'] = '2019-09-01';
        }        
        if (isset($this->request->query['hasta'])){
            $this->request->data['Reportes']['hasta'] = $this->request->query['hasta'];
        }else{
            $this->request->data['Reportes']['hasta'] = '2019-09-30';
        }        
        if (isset($this->request->query['ghostZoom'])){
            $this->request->data['Reportes']['ghostZoom'] = $this->request->query['ghostZoom'];
        }        
        if (isset($this->request->query['centroZoom'])){
            $this->request->data['Reportes']['centroZoom'] = $this->request->query['centroZoom'];
        }
        if (isset($this->request->query['buscar'])){
            $this->request->data['Reportes']['buscar'] = $this->request->query['buscar'];
            /*
            $url = "https://nominatim.openstreetmap.org/?format=json&q=Comisaria&polygon_geojson=0&viewbox=-77.066535,-11.960714,-77.027608,-12.017779&bounded=1&limit=100"; // Cesar
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
            curl_setopt($ch, CURLOPT_URL, $url);
            $geo = curl_exec($ch);
            curl_close($ch);
            
            //$geo = file_get_contents($url);            
            //$geo = json_decode($geo, true);
            pr($geo); exit;
            */
        }
        if (isset($this->request->query['viewbox'])){
            $this->request->data['Reportes']['viewbox'] = $this->request->query['viewbox'];
        }
        
        if (isset($this->request->query['horas'])){
            $horas = $this->request->data['Reportes']['horas'] = $this->request->query['horas'];
            $horas = explode(' - ', $horas);
            //pr($horas);
            
            $horas1 = explode(':', $horas[0]);
            //pr($horas1);
            $pos = strpos($horas[0], 'PM');
            if($pos !== false && $horas1[0] != 12){
                $horas1[0] +=12; 
            }
            
            $pos = strpos($horas[0], 'AM');
            if($pos !== false && $horas1[0] == 12){
                $horas1[0] =0;
            }
            
            $horas1 = $horas1[0];
            
            $horas2 = explode(':', $horas[1]);
            $pos = strpos($horas[1], 'PM');
            if($pos !== false && $horas2[0] != 12){
                $horas2[0] +=12;
            }
            
            $pos = strpos($horas[1], 'AM');
            if($pos !== false && $horas2[0] == 12){
                $horas2[0] =0;
            }
            if ($horas[1] == '11:59 PM'){
                $horas2[0] =24;
            }
            
            $horas2 = $horas2[0];
            
        }else{
            $this->request->data['Reportes']['horas'] = '12:00 AM - 11:59 PM';
            $horas1 = '0';
            $horas2 = '24';
        }
        
        //pr($horas1);
        //pr($horas2);
        $tipoDenuncias = $this->TipoDenuncia->find('all', array('fields'       => array('TipoDenuncia.id','TipoDenuncia.nombre'),
                                                'conditions'   => array('TipoDenuncia.id !=' => array(8,9),'TipoDenuncia.estado' => 'A'),
                                                'recursive'   => -1
                                            ));
        //pr($tipoDenuncias); exit;
        //$denuncias = $this->Denuncia->find('all', array('fields' => array('DISTINCT Denuncia.categoria')));
        //pr($denuncias); exit;
        
        $ckdAll = false;
        if (isset($this->request->query['ckdAll'])){
            $ckdAll = true;
            $this->request->data['Reportes']['ckdAll'] = 'checked';
        }else{
            $this->request->data['Reportes']['ckdAll'] = false;
        }
        
        $conditions = array_merge($conditions,array("distrito_id"=> $distrito_ids));
        //$conditions = array_merge($conditions,array("estado_google"=> 'OK', 'ST_Distance(Distrito.geom, Point(ST_X(Denuncia.geom), ST_Y(Denuncia.geom)))*110 <= 1'));
        $conditions = array_merge($conditions,array("estado_google"=> 'OK'));
        $conditions = array_merge($conditions,array("fecha_hecho >=" => $this->request->data['Reportes']['fecha_de']));
        $conditions = array_merge($conditions,array("fecha_hecho <=" => $this->request->data['Reportes']['hasta']));
        $conditions = array_merge($conditions,array("HOUR(fecha_hecho) >=" => $horas1));
        $conditions = array_merge($conditions,array("HOUR(fecha_hecho) <=" => $horas2));
        //pr($conditions);
        
        $options = array('fields' => array('Denuncia.id'),
            'conditions'=> $conditions
        );
        
        $total = $this->Denuncia->find('count',$options);        
        
        if (!empty($tipoDenuncias)){            
            
            foreach ($tipoDenuncias as $i => $tipoDenuncia){
                
                $conditions = array_merge($conditions,array('Denuncia.tipo_denuncia_id' => $tipoDenuncia['TipoDenuncia']['id']));                
                $options = null;
                //pr($conditions);
                $options = array('fields' => array('Denuncia.id'),
                                 'conditions'=> $conditions
                                 );
                
                $subTotal = $this->Denuncia->find('count',$options);                 
                
                $tipoDenuncias[$i]['Denuncia']['id'] = strtolower(str_replace(' ', '_', $tipoDenuncia['TipoDenuncia']['nombre']));
                $tipoDenuncias[$i]['Denuncia']['img'] = "./img/map/".strtolower(str_replace(' ', '_', $tipoDenuncia['TipoDenuncia']['nombre'])).'_20px.png';
                $tipoDenuncias[$i]['Denuncia']['subTotal'] = $subTotal;
                
                $checked = false;
                if (isset($this->request->query['delito'][$tipoDenuncias[$i]['Denuncia']['id']]) || $ckdAll){
                    $checked = 'checked';
                }
                $tipoDenuncias[$i]['Denuncia']['checked'] = $checked;
                
            }
        }
        
        if (isset($this->request->query['delito'])){
            $this->request->data['Reportes']['delito'] = $this->request->query['delito'];
        }
        //pr($this->request->data); exit;
        //pr($tipoDenuncias);exit;
        
        $this->set(compact('departamentos','provincias','distritos','distrito', 'tipoDenuncias', 'denuncias','total','horas1','horas2'));

    }
    
    public function delito() { 
        
    }
    
    public function cuadroDelito(){
        
        /********Filtros momentaneos para Perla y Iquitos*******/
        unset($this->request->query['n']);
        if(empty($this->request->query)){
            $filtros = Array
            (
                'departamento_id' => 15,
                'provincia_id' => 112,
                'distrito_id' => 842,
                'fecha_de' => '2019-09-01',
                'hasta' => '2019-09-15',
                'horas' => '12:00 AM - 11:59 PM',
                'horas1' => 0,
                'horas2' => 24,
                'delito'=> array('hurto'=>'on','robo'=>'on')
                );
            $this->request->query = $filtros;
        }
        
        /********Filtros momentaneos para Perla y Iquitos*******/
        
        
        $this->loadModel('Departamento');
        $this->loadModel('Provincia');
        $this->loadModel('Distrito');
        $this->loadModel('Denuncia');
        
        $options = array('recursive'=>-1);
        $departamentos = $this->Departamento->find('list',$options);
        
        //pr($this->request->query);
        $conditions = array();
        $provincias = null;
        if (isset($this->request->query['departamento_id'])){
            $departamento_id = $this->request->data['Reportes']['departamento_id'] = $this->request->query['departamento_id'];
            $options = array('conditions' => array('departamento_id' => $departamento_id),
                'recursive' => -1
            );
            $provincias = $this->Provincia->find('list',$options);
        }else{
            $departamento_id = 0;
        }
        
        $distritos = null;
        $a_distrito_id = null;
        if (isset($this->request->query['provincia_id']) && !empty($this->request->query['provincia_id'])){
            $provincia_id = $provincia_ids = $this->request->data['Reportes']['provincia_id'] = $this->request->query['provincia_id'];
            $options = array('conditions' => array('provincia_id' => $provincia_id),
                'order' =>array('Distrito.nombdist' => 'asc'),
                'recursive' => -1
            );
            $distritos = $this->Distrito->find('list',$options);
            
        }else{
            $options           = array('fields'     => array('DISTINCT id'),
                'conditions'   =>  array('departamento_id' => $departamento_id),
                'recursive'  => -1);
            $provincias_act    = $this->Distrito->Provincia->find('all',$options);
            $provincia_ids     = Hash::extract($provincias_act, '{n}.Provincia.id');
        }
        
        if (isset($this->request->query['distrito_id']) && !empty($this->request->query['distrito_id'])){
            
            $distrito_id = $distrito_ids = $this->request->data['Reportes']['distrito_id'] = $this->request->query['distrito_id'];
            
            $options = array('conditions' => array('Distrito.id' => $distrito_id),
                'order' =>array('Distrito.nombdist' => 'asc'),
                'recursive' => -1
            );
            
            $distrito = $this->Distrito->find('first',$options);
            $distrito['Distrito']['nombdist'] = ucwords(strtolower($distrito['Distrito']['nombdist']));
        }else{
            $options           = array( 'fields'     =>  array('DISTINCT id'),
                'conditions' =>  array('provincia_id' => $provincia_ids),
                'recursive'  =>  -1);
            $polygon_activo    = $this->Distrito->find('all',$options);
            $distrito_ids      = Hash::extract($polygon_activo, '{n}.Distrito.id');
        }

        
        $this->set(compact('departamentos','provincias','distritos','distrito', 'total'));
        
        
    }
}