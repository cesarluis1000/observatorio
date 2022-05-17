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
                'distrito_id' => 842,
                'fecha_de' => '2020-01-01',
                'hasta' => '2021-12-31',
                'horas' => '12:00 AM - 11:59 PM',
                'horas1' => 0,
                'horas2' => 24,
                'delito'=> array('robo_de_celular'=>'on','sicariato')
                );
            $this->request->query = $filtros;
        }

        /********Filtros momentaneos para Perla y Iquitos*******/

        $this->loadModel('Departamento');
        $this->loadModel('Provincia');
        $this->loadModel('Distrito');
        $this->loadModel('Denuncia');
        $this->loadModel('TipoDenuncia');
        $this->loadModel('Parametro');

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

            /*****Distrito del Gerente de seguridad******/
            $currentUser = $this->Auth->user();
            $options2 = array('conditions' => array('variable' => $currentUser['username'],
                'modulo' => 'municipalidad'));
            $param = $this->Parametro->find('first',$options2);

            if (isset($param['Parametro']['valor']) && !empty($param['Parametro']['valor'])){
                $options['conditions']['id'] = $param['Parametro']['valor'];
                $this->request->query['distrito_id'] = $param['Parametro']['valor'];
            }
            /***********/

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
/*$distrito_ids = array(860,880,872,867,933,902,947,911);     //Norte
$distrito_ids = array(889,824,844,852,830,846,848,885,859); //Este
$distrito_ids = array(842,829,850,832,802,821,819,825,794,815,814,811,805,816,812,791);//centro
$distrito_ids = array(797,784,796,827,787,785,779,750,740,739);//Sur*/
            $options = array('conditions' => array('Distrito.id' => $distrito_id),
                'order' =>array('Distrito.nombdist' => 'asc'),
                'recursive' => -1
            );

            $distrito = $this->Distrito->find('first',$options);
            //pr($distrito);

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
                                                                /*'conditions'   => array('TipoDenuncia.id' => array(13,14),'TipoDenuncia.estado' => 'A'),*/
                                                                'conditions'   => array('TipoDenuncia.id' => array(1,2,3,4,5,6,7,9,10,11,13,14),'TipoDenuncia.estado' => 'A'),
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
        //pr($conditions); exit;

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
                'fecha_de' => '2021-01-01',
                'hasta' => '2021-12-31',
                'horas' => '12:00 AM - 11:59 PM',
                'horas1' => 0,
                'horas2' => 24,
                'delito'=> array('robo_de_celular'=>'on','sicariato')
                );
            $this->request->query = $filtros;
        }

        /********Filtros momentaneos para Perla y Iquitos*******/


        $this->loadModel('Departamento');
        $this->loadModel('Provincia');
        $this->loadModel('Distrito');
        $this->loadModel('Denuncia');
        $this->loadModel('Parametro');

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


            /*****Distrito del Gerente de seguridad******/
            $currentUser = $this->Auth->user();
            $options2 = array('conditions' => array('variable' => $currentUser['username'],
                                                    'modulo' => 'municipalidad'));
            $param = $this->Parametro->find('first',$options2);

            if (isset($param['Parametro']['valor']) && !empty($param['Parametro']['valor'])){
                $options['conditions']['id'] = $param['Parametro']['valor'];
                $this->request->query['distrito_id'] = $param['Parametro']['valor'];
            }
            /***********/
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

		//filtro de hora
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

		$conditions = array_merge($conditions,array("distrito_id"=> $distrito_ids));
		$conditions = array_merge($conditions,array("estado_google"=> 'OK'));
		$conditions = array_merge($conditions,array("fecha_hecho >=" => $this->request->data['Reportes']['fecha_de']));
        $conditions = array_merge($conditions,array("fecha_hecho <=" => $this->request->data['Reportes']['hasta']));
		$conditions = array_merge($conditions,array("HOUR(fecha_hecho) >=" => $horas1));
        $conditions = array_merge($conditions,array("HOUR(fecha_hecho) <=" => $horas2));


		$options = array('fields' => array('Denuncia.id'),
			'conditions'=> $conditions
		);

		$total = $this->Denuncia->find('count',$options);


		if (isset($this->request->query['delito'])){
            $this->request->data['Reportes']['delito'] = $this->request->query['delito'];
        }


        $this->set(compact('departamentos','provincias','distritos','distrito','denuncias','total','horas1','horas2'));

    }


	public function cuadroPreso(){

        /********Filtros momentaneos para Perla y Iquitos*******/
        unset($this->request->query['n']);
        if(empty($this->request->query)){
            $filtros = Array
            (
                'delito_generico_id' => 1,
                'delito_especifico_id' => 1,
				'sit_juridi' => 'Procesado',
				//'sexo' => 'M',
				'fecha_ingreso' => '2017-01-01',
                //'tipo_documento_id' =>1,
                );
            $this->request->query = $filtros;
        }

        /********Filtros momentaneos para Perla y Iquitos*******/

		$this->loadModel('DelitoGenerico');
        $this->loadModel('DelitoEspecifico');
        //$this->loadModel('TipoDocumento');
        $this->loadModel('Preso');
        $this->loadModel('Parametro');

        $options = array('recursive'=>-1);
        $de_genericos = $this->DelitoGenerico->find('list',$options);
		//print_r($de_genericos);exit;

        //pr($this->request->query);
        $conditions = array();
        $de_especificos = null;
        if (isset($this->request->query['delito_generico_id'])){
            $delito_generico_id = $this->request->data['Reportes']['delito_generico_id'] = $this->request->query['delito_generico_id'];
            $options = array('conditions' => array('delito_generico_id' => $delito_generico_id),
                'recursive' => -1
            );
            $de_especificos = $this->DelitoEspecifico->find('list',$options);
        }else{
            $delito_generico_id = 0;
        }

		if (isset($this->request->query['delito_especifico_id']) && !empty($this->request->query['delito_especifico_id'])){
            $delito_especifico_id = $de_especifico_ids = $this->request->data['Reportes']['delito_especifico_id'] = $this->request->query['delito_especifico_id'];
            $options = array('conditions' => array('delito_especifico_id' => $delito_especifico_id),
                             'recursive' => -1
                            );

            /*****Distrito del Gerente de seguridad******/
            $currentUser = $this->Auth->user();
            $options2 = array('conditions' => array('variable' => $currentUser['username'],
                                                    'modulo' => 'municipalidad'));
            $param = $this->Parametro->find('first',$options2);

            if (isset($param['Parametro']['valor']) && !empty($param['Parametro']['valor'])){
                $options['conditions']['id'] = $param['Parametro']['valor'];
                //$this->request->query['distrito_id'] = $param['Parametro']['valor'];
            }
            /***********/
            //$distritos = $this->Distrito->find('list',$options);

        }else{
            $options           = array('fields'     => array('DISTINCT id'),
                'conditions'   =>  array('delito_generico_id' => $delito_generico_id),
                'recursive'  => -1);
            $de_especificos_act    = $this->DelitoEspecifico->DelitoGenerico->find('all',$options);
            $de_especifico_ids     = Hash::extract($de_especificos_act, '{n}.DelitoEspecifico.id');
        }

		if (isset($this->request->query['sit_juridi'])){
            $this->request->data['Reportes']['sit_juridi'] = $this->request->query['sit_juridi'];
        }else{
            $this->request->data['Reportes']['sit_juridi'] = 'Procesado';
        }

		if (isset($this->request->query['fecha_ingreso'])){
            $this->request->data['Reportes']['fecha_ingreso'] = $this->request->query['fecha_ingreso'];
        }else{
            $this->request->data['Reportes']['fecha_ingreso'] = '2017-01-01';
        }

		$conditions = array_merge($conditions,array("fecha_ingreso >=" => $this->request->data['Reportes']['fecha_ingreso']));

		$options = array('fields' => array('Preso.id'),
			'conditions'=> $conditions
		);

		$total = $this->Preso->find('count',$options);


		$this->set(compact('de_genericos','de_especificos','presos','total'));

    }

}
